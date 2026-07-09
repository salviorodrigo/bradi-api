<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Templates;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\ValidationService as ValidationServiceProtocol;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Validators\RootTagValidator;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;

abstract class DFeElement
{
    public const string FIELD_NAME = '';

    public readonly string $fieldURI;

    public ?string $value;

    private ?Element $sourceElement;
    private ValidationServiceProtocol $validationService;

    final public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::FIELD_NAME : $parentFieldURI . '.' . static::FIELD_NAME;
        $this->validationService = new ValidationService($this->fieldURI, __METHOD__);

        if (! defined(static::class . '::FIELD_NAME') || static::FIELD_NAME === '') {
            throw new RuntimeException(sprintf(
                'The class "%s" must define a constant "FIELD_NAME" with the name of the XML tag it represents.',
                static::class
            ));
        }
    }

    /** @return Result<DFeElement|ApiError> */
    final public function parseFromXmlElement(Element $element): Result
    {
        $validationSteps = [
            fn ($candidate) => $this->validateRootTag($candidate),
            fn ($candidate) => $this->validateTagAttributes($candidate),
            fn ($candidate) => $this->validateTagElements($candidate),
            fn ($candidate) => $this->validateTagValue($candidate),
        ];

        foreach ($validationSteps as $validationService) {
            $validationResult = $validationService($element);
            if ($validationResult->isFailure()) {
                return $validationResult;
            }
        }

        $hydrateResult = $this->hydrateFromXmlElement($element);
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
    }

    /** @return array<Validator> */
    abstract protected function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagElementsValidators(): array;

    /** @return Result<null|ApiError> */
    final protected function validateRootTag(Element $element): Result
    {
        $this->validationService->reset();
        $this->validationService->addValidator(new RootTagValidator(static::FIELD_NAME));

        return $this->validationService->verify($element);
    }

    /** @return Result<null|ApiError> */
    final protected function validateTagValue(Element $element): Result
    {
        $candidate = $element->value ?? '';
        $this->validationService->reset();
        foreach ($this->tagValueValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($candidate);
    }

    /** @return Result<null|ApiError> */
    final protected function validateTagAttributes(Element $element): Result
    {
        $this->validationService->reset();
        foreach ($this->tagAttributesValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($element);
    }

    /**  @return Result<null|ApiError> */
    final protected function validateTagElements(Element $element): Result
    {
        $this->validationService->reset();
        foreach ($this->tagElementsValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($element);
    }

    /** @return Result<null|ApiError> **/
    private function hydrateFromXmlElement(Element $xmlElement): Result
    {
        if (isset($xmlElement->value)) {
            $this->value = $xmlElement->value;
        }

        $propsMetadata = $this->listChildElements();
        [$requiredElements, $optionalElements] = array_reduce($propsMetadata, function (array $carry, array $element) {
            $element['isOptional'] ? $carry[1][] = $element : $carry[0][] = $element;

            return $carry;
        }, [[], []]);

        $parserErrorBag = [];
        foreach ($requiredElements as $element) {
            $concreteElement = new $element['class']($this->fieldURI);
            $parsingResult = $concreteElement->parseFromXmlElement($xmlElement->{$concreteElement::class::FIELD_NAME});
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['propertyName']} = $parsingResult->getData();
        }

        foreach ($optionalElements as $element) {
            $concreteElement = new $element['class']($this->fieldURI);
            if (! isset($xmlElement->{$concreteElement::class::FIELD_NAME})) {
                continue;
            }

            $parsingResult = $concreteElement->parseFromXmlElement($xmlElement->{$concreteElement::class::FIELD_NAME});
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['propertyName']} = $parsingResult->getData();
        }

        if (count($parserErrorBag) > 0) {
            $parsingError = array_shift($parserErrorBag);
            foreach ($parserErrorBag as $error) {
                $parsingError->merge($error);
            }

            return Result::makeFailure($parsingError);
        }

        $this->sourceElement = $xmlElement;

        return Result::makeSuccess();
    }

    /** @return array<array{parentClass: string, class:string,propertyName:string,isOptional:bool,isSet:bool}> */
    private function listChildElements(): array
    {
        $elementsList = [];
        $reflection = new ReflectionClass($this);
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (! $property->hasType()) {
                continue;
            }

            $propertyType = $property->getType();
            if (! $propertyType instanceof ReflectionNamedType || $propertyType->isBuiltin()) {
                continue;
            }

            $elementClass = new ReflectionClass($propertyType->getName());
            $parentClass = $elementClass->getParentClass();
            $allowedClasses = [DFeElement::class, DFeAttribute::class];
            if (! array_reduce($allowedClasses, fn (bool $carry, string $allowedClass) => $carry || is_a($parentClass->getName(), $allowedClass, true), false)) {
                continue;
            }

            $elementsList[] = [
                'parentClass' => $parentClass->getName(),
                'class' => $elementClass->getName(),
                'propertyName' => $property->getName(),
                'isOptional' => $propertyType->allowsNull(),
                'isSet' => isset($this->{$property->getName()}),
            ];
        }

        return $elementsList;
    }

    final public function __toString(): string
    {
        // verify is all  delcared and stted properties are setted into Element instance, if not, set them before return the string ordenation is important. Verify if all values are equals, if not, update the Element instance with the current values. If all values are equals, return the string.
        if (isset($this->sourceElement)) {
            return (string) $this->sourceElement;
        }

        $this->validationService->reset();
        $this->sourceElement = new Element;
        $this->sourceElement->name = static::FIELD_NAME;

        if (isset($this->value)) {
            $this->sourceElement->value = $this->value;
        }

        $propsMetadata = $this->listChildElements();
        if (! empty($propsMetadata)) {
            $elementsList = array_filter($propsMetadata, fn (array $element) => $element['parentClass'] === DFeElement::class);
            $attributesList = array_filter($propsMetadata, fn (array $element) => $element['parentClass'] === DFeAttribute::class);

            foreach ($attributesList as $attribute) {
                if (! isset($this->{$attribute['propertyName']}) && ! $attribute['isOptional']) {
                    throw new RuntimeException(sprintf(
                        'Required attribute "%s" not initialized.',
                        $attribute['propertyName']
                    ));
                }

                if (! isset($this->{$attribute['propertyName']})) {
                    continue;
                }

                $attributeInstance = new Attribute(
                    $attribute['propertyName'],
                    $this->{$attribute['propertyName']}->value,
                    static::FIELD_NAME
                );

                $this->sourceElement->addAttribute($attributeInstance);
            }

            foreach ($elementsList as $element) {
                if (! isset($this->{$element['propertyName']}) && ! $element['isOptional']) {
                    throw new RuntimeException(sprintf(
                        'Required element "%s" not initialized.',
                        $element['propertyName']
                    ));
                }

                if (! isset($this->{$element['propertyName']})) {
                    continue;
                }

                $elementInstance = new Element;
                $elementInstance->parse((string) $this->{$element['propertyName']});
                $this->sourceElement->addChild($elementInstance);
            }
        }

        return (string) $this->sourceElement;
    }
}
