<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Xml\ValueObjects;

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
            throw new InvalidArgumentException('Elements cannot be duplicated.');
        }
        $this->records[] = $child;
    }

    private function exists(Element $element): bool
    {
        return array_find($this->records, fn (Element $existingElement) => $existingElement == $element) !== null;
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
