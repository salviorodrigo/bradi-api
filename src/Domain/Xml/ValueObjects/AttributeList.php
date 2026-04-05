<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Xml\ValueObjects;

use InvalidArgumentException;

final class AttributeList
{
    /**
     * @param  array<Attribute>  $records  indexed by $attribute->name
     */
    public array $records = [];

    public function add(Attribute $attribute): void
    {
        if ($this->exists($attribute)) {
            throw new InvalidArgumentException("Attribute with name '{$attribute->name}' already exists.");
        }

        $this->records[] = $attribute;
    }

    private function exists(Attribute $attribute): bool
    {
        return array_find($this->records, fn (Attribute $existingAttribute) => $existingAttribute->name === $attribute->name) !== null;
    }

    public function __get(string $name): ?Attribute
    {
        $attribute = array_find($this->records, fn (Attribute $attribute) => $attribute->name === $name);

        return $attribute ?? null;
    }
}
