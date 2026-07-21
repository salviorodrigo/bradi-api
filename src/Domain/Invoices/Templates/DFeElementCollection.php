<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Templates;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use Exception;
use ReflectionClass;

abstract class DFeElementCollection
{
    protected const string BASE_CLASS = '';

    /** @var DFeElement[] */
    public array $collection = [];

    private DFeElement $baseClass;
    private ValidationService $validationService;

    final public function __construct(private readonly string $parentFieldURI = '')
    {
        $this->validationService = new ValidationService($this->parentFieldURI);
    }

    /** @return Result<DFeElement|ApiError> */
    final public function parseFromXmlElement(Element|ElementList $elementOrElementList): Result
    {
        $elements = $this->normalizeElements($elementOrElementList);
        $validationResult = $this->validateCollection($elements);
        if ($validationResult->isFailure()) {
            $this->collection = [];

            return $validationResult;
        }
        foreach ($elements as $element) {
            $this->resetBaseClass();
            $dfeElement = $this->baseClass->parseFromXmlElement($element);
            if ($dfeElement->isFailure()) {
                return $dfeElement;
            }

            $this->collection[] = $dfeElement->getData();
        }

        return Result::makeSuccess($this);
    }

    abstract protected function collectionValidators(): array;

    final protected function validateCollection(array $elements): Result
    {
        $this->validationService->reset();
        foreach ($this->collectionValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($elements);
    }

    private function resetBaseClass(): void
    {
        if (class_exists(static::BASE_CLASS) === false) {
            throw new Exception('BASE_CLASS constant must be defined in the child class.');
        }

        if (is_subclass_of(static::BASE_CLASS, DFeElement::class) === false) {
            throw new Exception('BASE_CLASS must be a subclass of DFeElement.');
        }

        $this->baseClass = new (static::BASE_CLASS)($this->parentFieldURI);
    }

    private function normalizeElements(Element|ElementList $elementOrElementList): array
    {
        $elements = [];
        if ($elementOrElementList instanceof Element) {
            $elements[] = $elementOrElementList;
        }

        if ($elementOrElementList instanceof ElementList) {
            $elements = array_merge($elements, $elementOrElementList->collection);
        }

        return array_filter($elements, function ($element) {
            $reflectedBaseClass = new ReflectionClass(static::BASE_CLASS);

            return $element->name == $reflectedBaseClass->getConstant('FIELD_NAME');
        });
    }

    public function __toString()
    {
        throw new Exception('Not implemented');
    }
}
