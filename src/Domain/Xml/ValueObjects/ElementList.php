<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\ValueObjects;

use InvalidArgumentException;

final class ElementList
{
    /**
     * @param  array<Element>  $records
     */
    public array $records;

    public function __construct(array $records = [])
    {
        if (! array_all($records, fn ($record) => $record instanceof Element)) {
            throw new InvalidArgumentException('All records must be instances of ' . Element::class . '.');
        }

        $this->records = $records;
    }

    public function add(Element $child): void
    {
        if ($this->exists($child)) {
            throw new InvalidArgumentException('The same Element instance is already present in this list.');
        }
        $this->records[] = $child;
    }

    public function indexOf(Element $element): ?int
    {
        return array_find_key($this->records, fn (Element $record) => $record === $element);
    }

    public function insertAt(int $index, Element $element): void
    {
        if ($this->exists($element)) {
            throw new InvalidArgumentException('The same Element instance is already present in this list.');
        }

        array_splice($this->records, max(0, min($index, count($this->records))), 0, [$element]);
    }

    public function replace(Element $current, Element $replacement): void
    {
        $index = $this->indexOf($current);
        if ($index === null) {
            throw new InvalidArgumentException("Element \"{$current->name}\" is not in this list.");
        }

        $this->records[$index] = $replacement;
    }

    public function remove(Element $element): void
    {
        $index = $this->indexOf($element);
        if ($index === null) {
            throw new InvalidArgumentException("Element \"{$element->name}\" is not in this list.");
        }

        array_splice($this->records, $index, 1);
    }

    // Identity comparison: structurally equal siblings are legal in a DFe
    // (e.g. repeated <detPag> with the same content), only the same instance is a duplicate.
    private function exists(Element $element): bool
    {
        return array_find($this->records, fn (Element $existingElement) => $existingElement === $element) !== null;
    }

    public function __get(string $name): ElementList|Element|null
    {
        $elements = array_filter($this->records, fn (Element $element) => $element->name === $name);
        if (count($elements) > 1) {
            return new ElementList($elements);
        }

        return array_first($elements) ?? null;
    }
}
