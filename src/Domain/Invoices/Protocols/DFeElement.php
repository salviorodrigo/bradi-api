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
    public const string TAG_NAME = '';

    public string $value;
    public protected(set) string $xmlString;
    public protected(set) string $fieldURI;

    protected static function xmlParser(string $xmlString): DFeParser
    {
        return new XmlToDFeParser($xmlString);
    }
    /**
     * @param  array<string,string>  $attributes
     * @param  array<DFeElement>  $elements
     **/
    final protected function generateXmlString(string $tagValue = '', array $elements = [], array $attributes = [], bool $isAutoCloseTag = false): string
    {
        $xmlString = '';
        if ($tagValue == '' && empty($elements) && empty($attributes)) {
            return $xmlString;
        }

        if ($isAutoCloseTag) {
            $xmlString .= '<' . static::TAG_NAME;
            foreach ($attributes as $attributeName => $attributeValue) {
                $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
            }

            $xmlString .= '/>';

            return $xmlString;
        }

        $xmlString .= '<' . static::TAG_NAME;
        foreach ($attributes as $attributeName => $attributeValue) {
            $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
        }

        $xmlString .= '>';
        $xmlString .= $tagValue;
        foreach ($elements as $element) {
            $xmlString .= $element->xmlString;
        }

        $xmlString .= '</' . static::TAG_NAME . '>';

        return $xmlString;
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected function validateDataType(mixed $rawData, string $fieldURI): Result
    {
        $typeValidator = new ValidationService($fieldURI, __METHOD__)
            ->addValidator(new IsXmlStringValidator);

        return $typeValidator->verify($rawData);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected function validateTagValue(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->getTextContent();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach ($this->tagValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected function validateTagAttributes(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->listAttributes();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach ($this->tagAttributesValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<null|ApiError>
     **/
    final protected function validateTagElements(string $xmlString, string $fieldURI): Result
    {
        $candidate = static::xmlParser($xmlString)->listChildren();
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach ($this->tagElementsValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /**
     * @return Result<DFeElement|ApiError>
     **/
    final public function parse(mixed $rawData): Result
    {
        $fieldURI = $this->fieldURI;
        $xmlString = static::xmlParser(strval($rawData))->getFirst(static::TAG_NAME);

        $validationResults = [
            $this->validateDataType($rawData, $fieldURI),
            $this->validateTagAttributes($xmlString, $fieldURI),
            $this->validateTagElements($xmlString, $fieldURI),
            $this->validateTagValue($xmlString, $fieldURI),
        ];

        $validationFailures = array_filter(
            $validationResults,
            fn (Result $validationResult) => $validationResult->isFailure()
        );

        if (count($validationFailures) > 0) {
            $validationError = array_shift($validationFailures)->getError();
            foreach ($validationFailures as $failure) {
                $validationError->merge($failure->getError());
            }

            return Result::makeFailure($validationError);
        }
   
        $this->xmlString = $xmlString;
        $hydrateResult = $this->hydrate();
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
    }

    /**
     * @return Result<null|ApiError>
     **/
    private function hydrate(): Result
    {
        $this->value = static::xmlParser($this->xmlString)->getTextContent();

        $elementsMetadata = $this->listHydrationElements();
        if (empty($elementsMetadata)) {
            return Result::makeSuccess();
        }

        $parserErrorBag = [];
        foreach ($elementsMetadata['required'] as $element) {
            $parsingResult = $this->parseChildElement($element);
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['property']} = $parsingResult->getData();
        }

        foreach ($elementsMetadata['optional'] as $element) {
            $elementXmlString = self::xmlParser($this->xmlString)->getFirst($element['class']::TAG_NAME);
            if ($elementXmlString === '') {
                $this->{$element['property']} = null;

                continue;
            }

            $parsingResult = $this->parseChildElement($element);
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['property']} = $parsingResult->getData();
        }

        if (count($parserErrorBag) > 0) {
            $parsingError = array_shift($parserErrorBag);
            foreach ($parserErrorBag as $error) {
                $parsingError->merge($error);
            }

            return Result::makeFailure($parsingError);
        }

        return Result::makeSuccess();
    }

    /**
     * @return array{required: array<array{class: class-string<DFeElement>, property: string}>, optional: array<array{class: class-string<DFeElement>, property: string}>}
     */
    private function listHydrationElements(): array
    {
        $requiredElements = [];
        $optionalElements = [];

        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (
                in_array($property->getName(), ['value', 'xmlString', 'fieldURI'], true)
                || ! $property->hasType()
            ) {
                continue;
            }

            $propertyType = $property->getType();
            if (! $propertyType instanceof \ReflectionNamedType || $propertyType->isBuiltin()) {
                continue;
            }

            $elementClass = $propertyType->getName();
            if (! is_a($elementClass, self::class, true)) {
                continue;
            }

            $metadata = [
                'class' => $elementClass,
                'property' => $property->getName(),
            ];

            if ($propertyType->allowsNull()) {
                $optionalElements[] = $metadata;

                continue;
            }

            $requiredElements[] = $metadata;
        }

        return [
            'required' => $requiredElements,
            'optional' => $optionalElements,
        ];
    }

    /**
     * @param  array{class: class-string<DFeElement>, property: string}  $element
     * @return Result<DFeElement|ApiError>
     */
    private function parseChildElement(array $element): Result
    {
        $elementXmlString = self::xmlParser($this->xmlString)->getFirst($element['class']::TAG_NAME);
        $elementParser = new ($element['class'])($this->fieldURI);

        return $elementParser->parse($elementXmlString);
    }

    /** @return array<Validator> */
    abstract protected function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagElementsValidators(): array;
}

// TODO Make test file.
