<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Xml\ValueObjects;

use BradiNfeApi\Domain\Common\Protocols\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\Protocols\XmlIterator;

class Element
{
    public ?string $value = null;
    public string $name;

    public private(set) AttributeList $attributes;
    public private(set) ElementList $children;

    public function __construct(
        private readonly XmlIterator $iterator,
        private readonly ValidationService $validationService
    ) {
        $this->attributes = new AttributeList;
        $this->children = new ElementList;
    }

    public function addChild(Element $child): void
    {
        $this->children->add($child);
    }

    public function addAttribute(Attribute $attribute): void
    {
        $this->attributes->add($attribute);
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
            $this->addAttribute(new Attribute($attributeName, $attributeValue));
        }

        foreach ($this->iterator->children as $child) {
            $childElement = new Element($this->iterator, $this->validationService);
            $childElement->parse($child);
            $this->addChild($childElement);
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
        $xmlString .= htmlspecialchars($this->value ?? '', ENT_XML1, 'UTF-8');
        foreach ($this->children->records as $child) {
            $xmlString .= (string) $child;
        }

        $xmlString .= '</' . $this->name . '>';

        return $xmlString;
    }
}
