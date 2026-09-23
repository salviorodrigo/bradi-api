<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\Protocols\XmlIterator;
use BradiApi\Infra\Parses\XmlStringIterator;
use InvalidArgumentException;

class Element
{
    public ?string $value = null;
    public string $name;

    public private(set) AttributeList $attributes;
    public private(set) ElementList $children;

    public function __construct(private readonly XmlIterator $iterator = new XmlStringIterator)
    {
        $this->attributes = new AttributeList;
        $this->children = new ElementList;
    }

    public function add(Attribute|Element|ElementList $child): void
    {
        match ($child::class) {
            Attribute::class => $this->attributes->add($child),
            default => $this->children->add($child),
        };
    }

    public function remove(Attribute|Element $target): void
    {
        match ($target::class) {
            Attribute::class => $this->attributes->remove($target),
            default => $this->children->remove($target),
        };
    }

    public function replace(Element|Attribute $oldChild, Element|Attribute $newChild): void
    {
        if ($oldChild::class !== $newChild::class) {
            throw new InvalidArgumentException('Cannot replace an Element with an Attribute or vice versa.');
        }

        $this->remove($oldChild);
        $this->add($newChild);
    }

    /**
     * @param  array<string>  $childNames
     * @param  array<string>  $attributeNames
     */
    public function sort(array $childNames = [], array $attributeNames = []): void
    {
        $this->children->sortByNames($childNames);
        $this->attributes->sortByNames($attributeNames);
    }

    public function isSet(string $childName): bool
    {
        return ! is_null($this->{$childName});
    }

    public function parse(mixed $rawData): Result
    {
        $loaderResponse = $this->iterator->loadFrom($rawData);
        if ($loaderResponse->isFailure()) {
            return $loaderResponse;
        }

        $this->name = $this->iterator->name;
        $this->value = $this->iterator->value;
        foreach ($this->iterator->attributes as $attributeName => $attributeValue) {
            $this->add(new Attribute($attributeName, $attributeValue));
        }

        foreach ($this->iterator->children as $target) {
            $targetElement = new Element;
            $targetElement->parse($target);
            $this->add($targetElement);
        }

        return Result::makeSuccess($this);
    }

    public function __get(string $name): Attribute|ElementList|Element|null
    {
        return $this->attributes->$name ?? $this->children->$name;
    }

    public function __toString(): string
    {
        $hasValue = $this->value !== null && $this->value !== '';
        $hasChildren = ! empty($this->children->records);

        $xmlString = '<' . $this->name;
        foreach ($this->attributes->records as $attribute) {
            $xmlString .= ' ' . (string) $attribute;
        }

        if (! $hasValue && ! $hasChildren) {
            return $xmlString . '/>';
        }

        $xmlString .= '>';
        $xmlString .= $this->value ?? '';
        foreach ($this->children->records as $target) {
            $xmlString .= (string) $target;
        }

        $xmlString .= '</' . $this->name . '>';

        return $xmlString;
    }
}
