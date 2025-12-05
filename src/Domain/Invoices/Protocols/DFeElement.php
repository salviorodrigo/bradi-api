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

    abstract public static function parseXmlString(mixed $rawData): Result;

    abstract public static function create(string $tagValue, array $elements, array $attributes): Result;
}

// TODO adicional metodo estatico de criar a partir de valores fornecidos
