<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Infra\Parses\XmlToDFeParser;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;

abstract class DFeElement
{
    public const string TAG_NAME = '';

    public ?string $value;

    public protected(set) string $xmlString;

    public readonly string $fieldURI;

    protected static function xmlParser(string $xmlString): DFeParser
    {
        return new XmlToDFeParser($xmlString);
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

    /** @return array<Validator> */
    abstract protected function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagElementsValidators(): array;

    private function generateXmlString(): string
    {
        $attributes = [];
        $elements = [];

        foreach ($this->listSerializationProperties() as $metadata) {
            $propertyName = $metadata['property'];
            $value = $this->{$propertyName};
            if ($metadata['type'] === 'attribute') {
                $attributes[] = $value;
            }

            if ($metadata['type'] === 'element') {
                $elements[] = $value;
            }
        }

        $xmlString = '';
        if (! isset($this->value) && empty($elements) && empty($attributes)) {
            return $xmlString;
        }

        $isAutoCloseTag = ! isset($this->value) && empty($elements);

        $xmlString .= '<' . static::TAG_NAME;
        foreach ($attributes as $attribute) {
            $xmlString .= ' ' . (string) $attribute;
        }

        if ($isAutoCloseTag) {
            $xmlString .= '/>';

            return $xmlString;
        }

        $xmlString .= '>';
        $xmlString .= $this->value ?? '';
        foreach ($elements as $element) {
            $xmlString .= (string) $element;
        }

        $xmlString .= '</' . static::TAG_NAME . '>';

        return $xmlString;
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

        $reflection = new ReflectionClass($this);
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (
                in_array($property->getName(), ['value', 'xmlString', 'fieldURI'], true)
                || ! $property->hasType()
            ) {
                continue;
            }

            $propertyType = $property->getType();
            if (! $propertyType instanceof ReflectionNamedType || $propertyType->isBuiltin()) {
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

    /**
     * @return array<array{property: string, type: 'element'|'attribute'}>
     */
    private function listSerializationProperties(): array
    {
        $properties = [];
        $reflection = new ReflectionClass($this);
        $concreteClassName = $reflection->getName();

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->getDeclaringClass()->getName() !== $concreteClassName) {
                continue;
            }

            $propertyType = $property->getType();
            if (! $propertyType instanceof ReflectionNamedType || $propertyType->isBuiltin()) {
                continue;
            }

            $propertyAllowsNull = $propertyType->allowsNull();
            if ($propertyAllowsNull && (! $property->isInitialized($this) || $this->{$property->getName()} === null)) {
                continue;
            }

            if (! $propertyAllowsNull && (! $property->isInitialized($this) || $this->{$property->getName()} === null)) {
                throw new RuntimeException("Property {$property->getName()} is not initialized.");
            }

            $typeClass = $propertyType->getName();
            if (is_a($typeClass, DFeAttribute::class, true)) {
                $propertyType = 'attribute';
            }

            if (is_a($typeClass, self::class, true)) {
                $propertyType = 'element';
            }

            if (! isset($propertyType)) {
                continue;
            }

            $properties[] = [
                'property' => $property->getName(),
                'type' => $propertyType,
            ];
        }

        return $properties;
    }

    final public function __toString(): string
    {
        if (isset($this->xmlString)) {
            return $this->xmlString;
        }

        $this->xmlString = $this->generateXmlString();

        return $this->xmlString;
    }
}

// TODO Make test file.
