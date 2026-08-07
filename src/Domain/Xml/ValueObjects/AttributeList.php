<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

use InvalidArgumentException;

final class AttributeList
{
    /** @var array<int,Attribute> Lista compacta; nomes sao unicos, garantido por add() */
    public array $records = [];

    public function add(Attribute $attribute): void
    {
        if ($this->exists($attribute)) {
            throw new InvalidArgumentException("Attribute with name '{$attribute->name}' already exists.");
        }

        $this->records[] = $attribute;
    }

    public function remove(Attribute $attribute): void
    {
        if ($this->exists($attribute)) {
            unset($this->records[$this->indexOf($attribute)]);
            $this->records = array_values($this->records);
        }
    }

    public function indexOf(Attribute $attribute): ?int
    {
        return array_find_key($this->records, fn (Attribute $record) => $record->name === $attribute->name);
    }

    public function exists(Attribute $attribute): bool
    {
        return $this->indexOf($attribute) !== null;
    }

    public function __get(string $name): ?Attribute
    {
        return array_find($this->records, fn (Attribute $attribute) => $attribute->name === $name);
    }
}
