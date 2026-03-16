<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

interface DFeParser
{
    public string $xmlString { get; }

    public function getFirst(string $tagName): string;

    public function listAll(string $tagName): array;

    public function getName(): string;

    public function getValue(): string;

    public function getTextContent(): string;

    public function listAttributes(): array;

    public function listChildren(): array;
}
