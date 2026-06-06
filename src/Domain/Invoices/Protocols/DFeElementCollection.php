<?php
declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

abstract class DFeElementCollection
{
    public readonly string $fieldURI;

    public function __construct(string $parentFieldURI = '', public readonly string $tagName)
    {
        $this->fieldURI = $parentFieldURI === '' ? $tagName : $parentFieldURI . '.' . $tagName;
    }

    /**
     * @var DFeElement[]
     */
    protected array $collection = [];

    public function add(DFeElement $dfe, string $key): void
    {
        if ($dfe::TAG_NAME !== $this->tagName) {
            throw new \InvalidArgumentException(sprintf('Expected tag name "%s", got "%s".', $this->tagName, $dfe::TAG_NAME));
        }

        $this->collection[] = $dfe;
    }

    public function __toString()
    {
        throw new \Exception('Not implemented');
    }
}