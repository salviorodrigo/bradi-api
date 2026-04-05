<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Xml\ValueObjects;

class Attribute
{
    public function __construct(
        public readonly string $name,
        public readonly string $value
    ) {}
}
