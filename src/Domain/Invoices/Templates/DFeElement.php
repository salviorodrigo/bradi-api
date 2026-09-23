<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Templates;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\DTOs\DFeElementPropertyMetadata;
use BradiApi\Domain\Invoices\Validators\RootTagValidator;
use BradiApi\Domain\Invoices\Validators\TagsSequenceValidator;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use BradiApi\Domain\Xml\ValueObjects\Element;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;

abstract class DFeElement
{
    public const ?string FIELD_NAME = null;
    public const array CHILD_ELEMENTS_ON_SEQUENCE = [];
    public const array CHILD_ATTRIBUTES_ON_SEQUENCE = [];

    public readonly string $fieldURI;

    public ?string $value = null;

    private ?Element $source;

    private ValidationService $validationService;

    final public function __construct(string $parentFieldURI = '')
    {
        if (empty(static::FIELD_NAME)) {
            throw new RuntimeException(sprintf(
                'The class "%s" must define a constant "FIELD_NAME" with the name of the XML tag it represents.',
                static::class
            ));
        }

        $this->fieldURI = $parentFieldURI === '' ? static::FIELD_NAME : $parentFieldURI . '.' . static::FIELD_NAME;
        $this->validationService = new ValidationService($this->fieldURI);
    }

    /** @return Result<DFeElement|ApiError> */
    final public function parse(Element $element): Result
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

        $hydrateResult = $this->hydrate($element);
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
    }

    final public function toXML(): ?Element
    {
        $this->sync();

        return $this->source ?? null;
    }

    final public function toString(): string
    {
        $this->sync();

        return (string) ($this->source ?? '');
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
        $this->validationService->addValidator(new TagsSequenceValidator(static::CHILD_ELEMENTS_ON_SEQUENCE));

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

    private function initSource(): void
    {
        if (! $this->hasChildData() && ! isset($this->value)) {
            $this->source = null;

            return;
        }

        $this->source = new Element;
        $this->source->name = static::FIELD_NAME;
        if (isset($this->value)) {
            $this->source->value = $this->value;
        }

        $this->sync();
    }

    /** @return Result<null|ApiError> **/
    private function hydrate(Element $xmlElement): Result
    {
        $propsMetadata = $this->listChildElements();
        $parserErrorBag = [];
        foreach ($propsMetadata as $dfeChild) {
            unset($this->{$dfeChild->name});
            if ($xmlElement->isSet($dfeChild->class::FIELD_NAME)) {
                $concreteElement = new $dfeChild->class($this->fieldURI);
                $parsingResult = match ($dfeChild->parentClass) {
                    DFeElementCollection::class => $concreteElement->parse($xmlElement),
                    default => $concreteElement->parse($xmlElement->{$concreteElement::class::FIELD_NAME}),
                };

                if ($parsingResult->isFailure()) {
                    $parserErrorBag[] = $parsingResult->getError();

                    continue;
                }

                $this->{$dfeChild->name} = $parsingResult->getData();
            }
        }

        if (count($parserErrorBag) > 0) {
            $parsingError = array_shift($parserErrorBag);
            foreach ($parserErrorBag as $error) {
                $parsingError->merge($error);
            }

            return Result::makeFailure($parsingError);
        }

        $this->source = $xmlElement;
        $this->value = null;
        if (isset($xmlElement->value)) {
            $this->value = $xmlElement->value;
        }

        return Result::makeSuccess();
    }

    private function sync(): void
    {
        if (! isset($this->source)) {
            if (! isset($this->value) && ! $this->hasChildData()) {
                return;
            }

            $this->initSource();
        }

        $propsMetadata = $this->listChildElements();
        foreach ($propsMetadata as $property) {
            $childSource = $property->isSet ? $this->{$property->name}->toXML() : null;

            if ($childSource === null) {
                if ($this->source->isSet($property->class::FIELD_NAME)) {
                    $this->source->remove($this->source->{$property->class::FIELD_NAME});
                }

                continue;
            }

            if (! $this->source->isSet($property->class::FIELD_NAME)) {
                $this->source->add($childSource);

                continue;
            }

            if ($this->source->{$property->class::FIELD_NAME} !== $childSource) {
                $this->source->replace(
                    $this->source->{$property->class::FIELD_NAME},
                    $childSource
                );
            }
        }

        $this->resolveSourceSequence();

        if ($this->source->value !== $this->value) {
            $this->source->value = $this->value;
        }
    }

    private function resolveSourceSequence(): void
    {
        $this->source->sort(
            childNames: static::CHILD_ELEMENTS_ON_SEQUENCE,
            attributeNames: static::CHILD_ATTRIBUTES_ON_SEQUENCE,
        );
    }

    /** @return array<DFeElementPropertyMetadata> */
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
            if (is_a($elementClass->getName(), Element::class, true) || is_a($elementClass->getName(), Attribute::class, true)) {
                continue;
            }

            $parentClass = $elementClass->getParentClass();
            $allowedClasses = [DFeElement::class, DFeAttribute::class];
            if (! array_reduce($allowedClasses, fn (bool $carry, string $allowedClass) => $carry || is_a($parentClass->getName(), $allowedClass, true), false)) {
                continue;
            }

            $elementsList[] = new DFeElementPropertyMetadata(
                parentClass: $parentClass->getName(),
                class: $elementClass->getName(),
                name: $property->getName(),
                isOptional: $propertyType->allowsNull(),
                isSet: isset($this->{$property->getName()}),
            );
        }

        return $elementsList;
    }

    private function hasChildData(): bool
    {
        $propsMetadata = $this->listChildElements();

        return array_reduce($propsMetadata, fn (bool $carry, DFeElementPropertyMetadata $property) => $carry || $property->isSet, false);
    }

    final public function __toString(): string
    {
        return $this->toString();
    }
}
