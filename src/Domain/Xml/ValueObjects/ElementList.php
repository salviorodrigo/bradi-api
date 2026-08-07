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

    public function add(Element|ElementList $child): void
    {
        $normalizedChildren = $child instanceof ElementList ? $child->records : [$child];
        foreach ($normalizedChildren as $normalizedChild) {
            if ($this->exists($normalizedChild)) {
                throw new InvalidArgumentException('The same Element instance is already present in this list.');
            }
        }

        $this->records = array_merge($this->records, $normalizedChildren);
    }

    public function indexOf(Element $element): ?int
    {
        return array_find_key($this->records, fn (Element $record) => $record === $element);
    }

    public function remove(Element $element): void
    {
        if ($this->exists($element)) {
            unset($this->records[$this->indexOf($element)]);
            $this->records = array_values($this->records);
        }
    }

    public function exists(Element $element): bool
    {
        return $this->indexOf($element) !== null;
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
