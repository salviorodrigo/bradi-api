<?php

declare(strict_types=1);

namespace BradiNfeApi\Infra\Parses;

use BradiNfeApi\Domain\Invoices\Protocols\DFeParser;

final class XmlToDFeParser implements DFeParser
{
    public function getTag(string $xmlString, string $tagName): string
    {
        return (string) $this->getTags($xmlString, $tagName)[0];
    }

    public function getTags(string $xmlString, string $tagName): array
    {
        $thisResponse = [];
        $pointer = 0;
        while ($this->existsTag($xmlString, $tagName, $pointer)) {
            $startPosition = $this->getStartPositionTag($xmlString, $tagName, $pointer);
            $endPosition = $this->getEndPositionTag($xmlString, $tagName, $startPosition);
            array_push($thisResponse, substr($xmlString,
                $startPosition,
                $endPosition - $startPosition
            ));
            $pointer = $endPosition;
        }

        return $thisResponse;
    }

    public function getTagValue(string $xmlString, string $tagName): string
    {
        return 'Method not implemented';
    }

    public function getTagAttributes(string $xmlString, string $tagName): array
    {
        return ['Method not implemented'];
    }

    private function existsTag(string $xmlString, string $tagName, int $offset = 0): bool
    {
        $xmlTag = '<' . $tagName;

        return strpos($xmlString, $xmlTag, $offset) !== false;
    }

    private function getStartPositionTag(string $xmlString, string $tagName, int $offset = 0): int
    {
        $xmlTag = '<' . $tagName;

        return (int) strpos($xmlString, $xmlTag, $offset);
    }

    private function getEndPositionTag(string $xmlString, string $tagName, int $offset): int
    {
        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($xmlString, $xmlTag, $offset) + strlen($xmlTag);
    }
}
