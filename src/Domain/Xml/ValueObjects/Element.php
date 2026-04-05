<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Xml\ValueObjects;

use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\XmlIterator;

class Element
{
    public private(set) AttributeList $attributes;

    public ?string $value = null;
    public string $name;

    private ElementList $children;

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

    public function __get(string $name): ElementList|Element|null
    {
        return $this->children->$name;
    }
}

/** To string method
 *
 *       $xmlString = '';
 *       if ($tagValue == '' && empty($elements) && empty($attributes)) {
 *           return $xmlString;
 *       }
 *
 *       if ($isAutoCloseTag) {
 *           $xmlString .= '<' . static::$tagName;
 *           foreach ($attributes as $attributeName => $attributeValue) {
 *               $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
 *           }
 *
 *           $xmlString .= '/>';
 *
 *           return $xmlString;
 *       }
 *
 *       $xmlString .= '<' . static::$tagName;
 *       foreach ($attributes as $attributeName => $attributeValue) {
 *           $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
 *       }
 *
 *       $xmlString .= '>';
 *       $xmlString .= $tagValue;
 *       foreach ($elements as $element) {
 *           $xmlString .= $element->xmlString;
 *       }
 *
 *       $xmlString .= '</' . static::$tagName . '>';
 *       return $xmlString;
 *   }
 **/
