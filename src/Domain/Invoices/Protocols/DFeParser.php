<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

interface DFeParser
{
    public function getTag(string $xmlString, string $tagName): string;

    public function getTags(string $xmlString, string $tagName): array;

    public function getTagValue(string $xmlString, string $tagName): string;

    public function getTagAttributes(string $xmlString, string $tagName): array;
}
