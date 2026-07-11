<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

class Attribute
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
        public readonly string $parentTagName
    ) {}

    public function __toString(): string
    {
        return $this->name . '="' . htmlspecialchars($this->value, ENT_QUOTES | ENT_XML1, 'UTF-8') . '"';
    }
}
