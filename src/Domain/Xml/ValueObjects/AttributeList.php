<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

use InvalidArgumentException;

final class AttributeList
{
    /**
     * @param  array<Attribute>  $records  indexed by $attribute->name
     */
    public array $records = [];

    public function add(Attribute $attribute): void
    {
        if ($this->exists($attribute->name)) {
            throw new InvalidArgumentException("Attribute with name '{$attribute->name}' already exists.");
        }

        $this->records[] = $attribute;
    }

    // Upsert overwriting in place: keeping the original position preserves
    // attributes the DFe model does not manage (e.g. infNFe "Id") across re-serializations.
    public function set(Attribute $attribute): void
    {
        $index = array_find_key($this->records, fn (Attribute $record) => $record->name === $attribute->name);
        if ($index === null) {
            $this->records[] = $attribute;

            return;
        }

        $this->records[$index] = $attribute;
    }

    public function exists(string $attributeName): bool
    {
        return array_find($this->records, fn (Attribute $existingAttribute) => $existingAttribute->name === $attributeName) !== null;
    }

    public function __get(string $name): ?Attribute
    {
        $attribute = array_find($this->records, fn (Attribute $attribute) => $attribute->name === $name);

        return $attribute ?? null;
    }
}
