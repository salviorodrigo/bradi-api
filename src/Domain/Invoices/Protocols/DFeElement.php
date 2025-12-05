<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Infra\Parses\XmlToDFeParser;

abstract class DFeElement
{
    public static string $tagName;

    public readonly string $value;
    public readonly string $xmlString;

    public static function xmlParser(): DFeParser
    {
        return new XmlToDFeParser;
    }

    protected static function generateXmlString(string $tagValue = '', array $elements = [], array $attributes = [], bool $isAutoCloseTag = false): string
    {
        $xmlString = '';

        if ($isAutoCloseTag) {
            $xmlString .= '<' . static::$tagName;
            foreach ($attributes as $attributeName => $attributeValue) {
                $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
            }
            $xmlString .= '/>';
        } else {
            $xmlString .= '<' . static::$tagName;
            foreach ($attributes as $attributeName => $attributeValue) {
                $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
            }
            $xmlString .= '>';
            $xmlString .= $tagValue;
            foreach ($elements as $element) {
                $xmlString .= $element->xmlString;
            }
            $xmlString .= '</' . static::$tagName . '>';
        }

        return $xmlString;
    }

    abstract public static function parseXmlString(mixed $rawData): Result;

    abstract public static function create(string $tagValue, array $elements, array $attributes): Result;
}

// TODO adicional metodo estatico de criar a partir de valores fornecidos
