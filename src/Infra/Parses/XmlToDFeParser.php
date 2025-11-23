<?php

declare(strict_types=1);

namespace BradiNfeApi\Infra\Parses;

use BradiNfeApi\Domain\Invoices\Protocols\DFeParser;

final class XmlToDFeParser implements DFeParser
{
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

    public function getTag(string $xmlString, string $tagName): string
    {
        $xmlTags = $this->getTags($xmlString, $tagName);

        return (string) count($xmlTags) == 0 ? '' : $xmlTags[0];
    }

    public function getTagValue(string $xmlString, string $tagName): string
    {
        if (! $this->existsTag($xmlString, $tagName) || $this->isComplexTypeXmlElement($xmlString, $tagName)) {
            return '';
        }
        $xmlTag = $this->getTag($xmlString, $tagName);
        $xmlInnerStartPosition = $this->getInnerStartPositionTag($xmlTag, $tagName);

        return substr(
            $xmlTag,
            $xmlInnerStartPosition,
            $this->getInnerEndPositionTag($xmlTag, $tagName, $xmlInnerStartPosition) - $xmlInnerStartPosition + 1
        );
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
        if ($this->isAutoClosedTag($xmlString, $tagName, $offset)) {
            return (int) strpos($xmlString, '>', $offset);
        }
        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($xmlString, $xmlTag, $offset) + strlen($xmlTag);
    }

    private function isComplexTypeXmlElement($xmlString, $tagName): bool
    {
        $xmlTag = $this->getTags($xmlString, $tagName)[0];

        return (bool) ($xmlTag[$this->getInnerStartPositionTag($xmlTag, $tagName)] == '<' || $xmlTag[$this->getInnerEndPositionTag($xmlTag, $tagName, strlen('<' . $tagName))] == '>');

    }

    private function isAutoClosedTag($xmlString, $tagName, int $offset = 0): bool
    {
        $startPosition = $this->getStartPositionTag($xmlString, $tagName, $offset);

        return $xmlString[strpos($xmlString, '>', $startPosition) - 1] == '/';
    }

    private function getInnerStartPositionTag(string $xmlString, string $tagName, int $offset = 0): int
    {
        $xmlTag = '<' . $tagName;

        return (int) strpos($xmlString, '>', strpos($xmlString, $xmlTag, $offset)) + 1;
    }

    private function getInnerEndPositionTag(string $xmlString, string $tagName, int $offset): int
    {
        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($xmlString, $xmlTag, $offset) - 1;
    }
}
