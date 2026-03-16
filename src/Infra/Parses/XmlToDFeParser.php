<?php

declare(strict_types=1);

namespace BradiNfeApi\Infra\Parses;

use BradiNfeApi\Domain\Invoices\Protocols\DFeParser;
use InvalidArgumentException;

final class XmlToDFeParser implements DFeParser
{
    public function __construct(public string $xmlString) {}

    public function listAll(string $tagName): array
    {
        if (empty($tagName)) {
            return [];
        }

        $list = [];
        $pointer = 0;
        while ($this->existsTag($tagName, $pointer)) {
            $startPosition = $this->getStartPositionTag($tagName, $pointer);
            $endPosition = $this->getEndPositionTag($tagName, $startPosition);
            $list[] = substr($this->xmlString, $startPosition, $endPosition - $startPosition);
            $pointer = $endPosition;
        }

        return $list;
    }

    public function getFirst(string $tagName): string
    {
        if (empty($tagName)) {
            return '';
        }

        $xmlTags = $this->listAll($tagName);

        return $xmlTags[0] ?? '';
    }

    public function getValue(): string
    {
        if (empty($this->xmlString)) {
            return '';
        }

        $tagName = $this->getName();
        if ($this->isAutoClosedTag($tagName)) {
            return '';
        }

        $xmlInnerStartPosition = $this->getInnerStartPositionTag($tagName);
        $xmlInnerEndPosition = $this->getInnerEndPositionTag($tagName, $xmlInnerStartPosition);

        return substr(
            $this->xmlString,
            $xmlInnerStartPosition,
            $xmlInnerEndPosition - $xmlInnerStartPosition + 1
        );

    }

    public function getTextContent(): string
    {
        if (empty($this->xmlString)) {
            return '';
        }

        $tagValue = $this->getValue();
        $children = $this->listChildren();
        foreach ($children as $child) {
            $tagValue = str_replace($child, '', $tagValue);
        }

        return $tagValue;
    }

    public function listAttributes(): array
    {
        if (empty($this->xmlString) || ! $this->hasAttribute()) {
            return [];
        }

        $attributesString = $this->getAttributesPart();
        $rawAttributes = explode(' ', $attributesString);
        $attributesList = [];
        foreach ($rawAttributes as $rawAttribute) {
            $rawAttribute = explode('=', $rawAttribute);
            $attributesList[$rawAttribute[0]] = $rawAttribute[1];
        }

        return $attributesList;
    }

    public function listChildren(): array
    {
        if (empty($this->xmlString)) {
            return [];
        }

        $childrenList = [];
        $pointer = $this->getInnerStartPositionTag($this->getName());
        while (strpos($this->xmlString, '<', $pointer) !== false) {
            $childName = $this->getName($pointer);
            if (! empty($childName)) {
                $childStartPosition = $this->getStartPositionTag($childName, $pointer);
                $childEndPosition = $this->getEndPositionTag($childName, $childStartPosition);
                $childrenList[$childName] = substr($this->xmlString, $childStartPosition, $childEndPosition - $childStartPosition);
                $pointer = $childEndPosition;
            } else {
                $pointer++;
            }
        }

        return $childrenList;
    }

    public function getName(int $offset = 0): string
    {
        if (empty($this->xmlString)) {
            return '';
        }

        $tagName = '';
        $startPosition = strpos($this->xmlString, '<', $offset);
        for ($i = $startPosition + 1; $i < strlen($this->xmlString); $i++) {
            if ($this->xmlString[$i] == ' ' || $this->xmlString[$i] == '>' || $this->xmlString[$i] == '/') {
                break;
            }

            $tagName .= $this->xmlString[$i];
        }

        return $tagName;
    }

    private function existsTag(string $tagName, int $offset = 0): bool
    {
        if (empty($tagName)) {
            return false;
        }

        $xmlTag = '<' . $tagName;
        $startPosition = strpos($this->xmlString, $xmlTag, $offset);
        if ($startPosition === false) {
            return false;
        }

        if ($this->xmlString[$startPosition + strlen($xmlTag)] != ' '
             && $this->xmlString[$startPosition + strlen($xmlTag)] != '>'
             && $this->xmlString[$startPosition + strlen($xmlTag)] != '/') {
            return $this->existsTag($tagName, $startPosition + strlen($xmlTag));
        }

        return true;
    }

    private function getStartPositionTag(string $tagName, int $offset = 0): int
    {
        $xmlTag = '<' . $tagName;
        $startPosition = strpos($this->xmlString, $xmlTag, $offset);

        if ($startPosition === false) {
            throw new InvalidArgumentException("Tag <{$tagName}> not found in the provided XML string.");
        }

        if ($this->xmlString[$startPosition + strlen($xmlTag)] != ' '
             && $this->xmlString[$startPosition + strlen($xmlTag)] != '>'
             && $this->xmlString[$startPosition + strlen($xmlTag)] != '/') {
            return $this->getEndPositionTag($tagName, $startPosition + strlen($xmlTag));
        }

        return (int) $startPosition;
    }

    private function getEndPositionTag(string $tagName, int $offset): int
    {
        if ($this->isAutoClosedTag($tagName, $offset)) {
            return (int) strpos($this->xmlString, '/>', $offset) + strlen('/>');
        }

        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($this->xmlString, $xmlTag, $offset) + strlen($xmlTag);
    }

    private function isAutoClosedTag(string $tagName, int $offset = 0): bool
    {
        $startPosition = $this->getStartPositionTag($tagName, $offset);

        return $this->xmlString[strpos($this->xmlString, '>', $startPosition) - 1] == '/';
    }

    private function getInnerStartPositionTag(string $tagName, int $offset = 0): int
    {
        $xmlTag = '<' . $tagName;

        return (int) strpos($this->xmlString, '>', strpos($this->xmlString, $xmlTag, $offset)) + 1;
    }

    private function getInnerEndPositionTag(string $tagName, int $offset): int
    {
        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($this->xmlString, $xmlTag, $offset) - 1;
    }

    private function hasAttribute(): bool
    {
        $tagName = $this->getName();

        return $this->xmlString[strlen("<{$tagName}")] === ' '
            && ! in_array($this->xmlString[strlen("<{$tagName}") + 1], ['>', '/']);
    }

    private function getAttributesPart(): string
    {
        $tagName = $this->getName();
        $attributesString = substr($this->xmlString, strlen('<' . $tagName) + 1, strpos($this->xmlString, '>') - strlen('<' . $tagName) - 1);
        $attributesString = substr($attributesString, 0, strrpos($attributesString, '"'));
        $attributesString = str_replace('"', '', $attributesString);

        return $attributesString;
    }
}
