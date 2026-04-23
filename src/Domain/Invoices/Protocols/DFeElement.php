<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Infra\Parses\XmlToDFeParser;

abstract class DFeElement
{
    public static string $tagName;

    public readonly string $value;
    public readonly string $xmlString;

    public static function xmlParser(string $xmlString): DFeParser
    {
        return new XmlToDFeParser($xmlString);
    }

    /**
     * @param  array<string,string>  $attributes
     * @param  array<DFeElement>  $elements
     **/
    protected static function generateXmlString(string $tagValue = '', array $elements = [], array $attributes = [], bool $isAutoCloseTag = false): string
    {
        $xmlString = '';
        if ($tagValue == '' && empty($elements) && empty($attributes)) {
            return $xmlString;
        }

        if ($isAutoCloseTag) {
            $xmlString .= '<' . static::$tagName;
            foreach ($attributes as $attributeName => $attributeValue) {
                $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
            }

            $xmlString .= '/>';

            return $xmlString;
        }

        $xmlString .= '<' . static::$tagName;
        foreach ($attributes as $attributeName => $attributeValue) {
            $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
        }

        $xmlString .= '>';
        $xmlString .= $tagValue;
        foreach ($elements as $element) {
            $xmlString .= $element->xmlString;
        }

        $xmlString .= '</' . static::$tagName . '>';

        return $xmlString;
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateDataType(mixed $rawData, string $fieldURI): Result
    {
        $typeValidator = new ValidationService($fieldURI, __METHOD__)
            ->addValidator(new IsXmlStringValidator);

        return $typeValidator->verify($rawData);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagValue(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->getTextContent();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach (static::tagValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagAttributes(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->listAttributes();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach (static::tagAttributesValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagElements(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->listChildren();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach (static::tagElementsValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<array{fieldURI: string, xmlString: string}|ApiError>
     **/
    final protected static function parser(
        mixed $rawData,
        string $parentFieldURI = ''
    ): Result {
        $fieldURI = $parentFieldURI === '' ? static::$tagName : $parentFieldURI . '.' . static::$tagName;
        $xmlString = static::xmlParser(strval($rawData))->getFirst(static::$tagName);

        $validationResults = [
            static::validateDataType($rawData, $fieldURI),
            static::validateTagAttributes($xmlString, $fieldURI),
            static::validateTagElements($xmlString, $fieldURI),
            static::validateTagValue($xmlString, $fieldURI),
        ];

        $mergedError = static::mergeValidationErrors($validationResults);
        if ($mergedError !== null) {
            return Result::makeFailure($mergedError);
        }

        return Result::makeSuccess([
            'fieldURI' => $fieldURI,
            'xmlString' => $xmlString,
        ]);
    }

    /**
     * @param  array<Result<null|ApiError>>  $validationResults
     */
    private static function mergeValidationErrors(array $validationResults): ?ApiError
    {
        $mergedError = null;

        foreach ($validationResults as $validationResult) {
            if (! $validationResult->isFailure()) {
                continue;
            }

            $error = $validationResult->getError();
            if (! $error instanceof ApiError) {
                continue;
            }

            if ($mergedError === null) {
                $mergedError = $error;

                continue;
            }

            $mergedError->merge($error);
        }

        return $mergedError;
    }

    /**
     * @return Result<DFeElement|ApiError>
     **/
    abstract public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result;

    /** @return array<Validator> */
    abstract protected static function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected static function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected static function tagElementsValidators(): array;
}

// TODO Make test file.
