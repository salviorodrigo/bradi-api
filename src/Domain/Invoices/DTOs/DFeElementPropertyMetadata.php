<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\DTOs;

final class DFeElementPropertyMetadata
{
    public function __construct(
        public string $parentClass,
        public string $class,
        public string $name,
        public bool $isOptional,
        public bool $isSet,
    ) {}
}
