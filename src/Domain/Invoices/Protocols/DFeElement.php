<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Infra\Parses\XmlToDFeParser;

abstract class DFeElement
{
    public readonly string $value;
    public readonly string $xmlString;

    public static function xmlParser(): DFeParser
    {
        return new XmlToDFeParser;
    }

    abstract public static function parseXmlString(mixed $rawData): Result;
}
