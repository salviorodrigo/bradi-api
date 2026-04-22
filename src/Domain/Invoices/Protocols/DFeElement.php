<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\OptionalValidation;
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
    final protected static function validateDataType(mixed $rawData, string $fieldURI, string $method, bool $isOptional = false): Result
    {
        $typeValidator = new ValidationService($fieldURI, $method)
            ->addValidator(new IsXmlStringValidator);

        if ($isOptional) {
            return (new OptionalValidation($typeValidator))->verify($rawData);
        }

        return $typeValidator->verify($rawData);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagValue(string $xmlString, string $fieldURI, string $method, bool $isOptional = false): Result
    {
        $candidate = static::xmlParser($xmlString)->getTextContent();
        $service = new ValidationService($fieldURI, $method);
        foreach (static::tagValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        if ($isOptional) {
            return (new OptionalValidation($service))->verify($candidate);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagAttributes(string $xmlString, string $fieldURI, string $method, bool $isOptional = false): Result
    {
        $candidate = static::xmlParser($xmlString)->listAttributes();
        $service = new ValidationService($fieldURI, $method);
        foreach (static::tagAttributesValidators() as $validator) {
            $service->addValidator($validator);
        }

        if ($isOptional) {
            return (new OptionalValidation($service))->verify($candidate);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected static function validateTagElements(string $xmlString, string $fieldURI, string $method, bool $isOptional = false): Result
    {
        if ($xmlString === '') {
            return Result::makeSuccess();
        }

        $candidate = static::xmlParser($xmlString)->listChildren();
        $service = new ValidationService($fieldURI, $method);
        foreach (static::tagElementsValidators() as $validator) {
            $service->addValidator($validator);
        }

        if ($isOptional) {
            return (new OptionalValidation($service))->verify($candidate);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<DFeElement|ApiError>
     **/
    abstract public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result;

    /**
     * @param  array<string,string>  $attributes
     * @param  array<DFeElement>  $elements
     * @return Result<DFeElement|ApiError>
     **/
    abstract public static function create(string $tagValue, array $elements, array $attributes, string $parentFieldURI = '', string $method = __METHOD__): Result;

    /** @return array<Validator> */
    abstract protected static function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected static function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected static function tagElementsValidators(): array;
}

// TODO Make test file.
