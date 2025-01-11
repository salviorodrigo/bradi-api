<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\ValueObject;

final class Id extends ValueObject
{
    private function __construct(public readonly mixed $value) {}

    public static function parse(mixed $rawData): Result
    {
        return Result::makeSuccess(new Id($rawData));
    }
}
