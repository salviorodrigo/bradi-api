<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Common\Result;

abstract class ValueObject
{
    public static string $fieldName;

    public readonly mixed $value;

    abstract public static function parse(mixed $rawData): Result;
}
