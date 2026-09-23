<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Templates;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use Exception;

abstract class DFeElementCollection
{
    protected const string BASE_CLASS = '';

    /** @var array<DFeElement> */
    public private(set) array $collection = [];

    private ?Element $source;
    /** @var array<Element> */
    private array $sourceCollection {
        get {
            $elementOrElementList = $this->source->{(static::BASE_CLASS)::FIELD_NAME};

            return match (get_class($elementOrElementList)) {
                ElementList::class => $elementOrElementList->records,
                Element::class => [$elementOrElementList],
                default => throw new Exception('Unexpected element child type.'),
            };
        }
    }

    private ValidationService $validationService;

    final public function __construct(private readonly string $parentFieldURI = '')
    {
        $this->validationService = new ValidationService($this->parentFieldURI);

        if (class_exists(static::BASE_CLASS) === false) {
            throw new Exception('BASE_CLASS constant must be defined in the child class.');
        }

        if (is_subclass_of(static::BASE_CLASS, DFeElement::class) === false) {
            throw new Exception('BASE_CLASS must be a subclass of DFeElement.');
        }

        if ((static::BASE_CLASS)::FIELD_NAME === '') {
            throw new Exception('FIELD_NAME constant must be defined in the child base class.');
        }
    }

    /** @return Result<DFeElement|ApiError> */
    final public function parse(Element $parentElement): Result
    {
        $validationResult = $this->validateRootTag($parentElement);
        if ($validationResult->isFailure()) {
            return $validationResult;
        }

        $collection = $this->filterElements($parentElement);
        $validationResult = $this->validateCollection($collection);
        if ($validationResult->isFailure()) {
            return $validationResult;
        }

        foreach ($collection as $element) {
            $dfeElementParsingResult = (new (static::BASE_CLASS)($this->parentFieldURI))->parse($element);
            if ($dfeElementParsingResult->isFailure()) {
                return $dfeElementParsingResult;
            }

            $this->collection[] = $dfeElementParsingResult->getData();
        }

        $this->source = $parentElement;

        return Result::makeSuccess($this);
    }

    final public function toString(): string
    {
        if (isset($this->source) === false) {
            return '';
        }

        return array_reduce(
            $this->sourceCollection,
            fn (string $xmlString, Element $source) => $xmlString . (string) $source,
            ''
        );
    }

    abstract protected function collectionValidators(): array;

    /** @return Result<null|ApiError> */
    final protected function validateRootTag(Element $parentElement): Result
    {
        $this->validationService->reset();
        $this->validationService->addValidator(new AtLeastOneTagValidator([(static::BASE_CLASS)::FIELD_NAME]));

        return $this->validationService->verify($parentElement);
    }

    final protected function validateCollection(array $elements): Result
    {
        $this->validationService->reset();
        foreach ($this->collectionValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($elements);
    }

    private function filterElements(Element $parentElement): array
    {
        $elementOrElementList = $parentElement->{(static::BASE_CLASS)::FIELD_NAME};

        return match (get_class($elementOrElementList)) {
            ElementList::class => $elementOrElementList->records,
            Element::class => [$elementOrElementList],
            default => throw new Exception('Unexpected element child type.'),
        };
    }

    final public function __toString(): string
    {
        return $this->toString();
    }
}
