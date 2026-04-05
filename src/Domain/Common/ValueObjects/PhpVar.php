<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

class PhpVar
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public mixed $value
    ) {}
}
