<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Protocols;

use BradiApi\Domain\Common\ValueObjects\Result;

abstract class ValueObject
{
    public static string $fieldURI;

    public readonly mixed $value;

    abstract public static function parse(mixed $rawData, string $parentFieldURI, string $method): Result;
}
