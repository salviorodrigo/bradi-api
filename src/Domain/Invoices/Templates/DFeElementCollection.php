<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Templates;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Domain\Xml\ValueObjects\ElementList;
use Exception;

abstract class DFeElementCollection
{
    private const string BASE_CLASS = '';
    /** @var DFeElement[] */
    public array $collection = [];
    private DFeElement $baseClass;

    final public function __construct(private readonly string $parentFieldURI = ''){}

    /** @return Result<DFeElement|ApiError> */
    final public function parseFromXmlElement(Element|ElementList $elementOrElementList): Result
    {
        $elements = $this->normalizeElements($elementOrElementList);
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

    public function __toString()
    {
        throw new Exception('Not implemented');
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
        if ($elementOrElementList instanceof Element) {
            return [$elementOrElementList];
        }

        return $elementOrElementList->records;
    }

    
}