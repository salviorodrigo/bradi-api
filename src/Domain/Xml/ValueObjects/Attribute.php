<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

class Attribute
{
    public function __construct(
        public readonly string $name,
        public ?string $value,
    ) {}

    public function __toString(): string
    {
        if ($this->value === null || $this->value === '') {
            return '';
        }

        return $this->name . '="' . $this->value . '"';
    }
}
