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

        if ($tagValue == '' && empty($elements) && empty($attributes)) {
            return $xmlString;
        }

        if ($isAutoCloseTag) {
            $xmlString .= '<' . static::$tagName;
            foreach ($attributes as $attributeName => $attributeValue) {
                $xmlString .= ' ' . $attributeName . '="' . $attributeValue . '"';
            }
            $xmlString .= '/>';

            return $xmlString;
        }

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

        return $xmlString;
    }

    abstract public static function parseXmlString(mixed $rawData): Result;

    abstract public static function create(string $tagValue, array $elements, array $attributes): Result;

    abstract public static function validateTagValue(string $tagValue): Result;
}

// TODO Make test file.
