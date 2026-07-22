<?php

declare(strict_types=1);

namespace BradiApi\Infra\Parses;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\Protocols\XmlIterator;
use Exception;

final class XmlStringIterator implements XmlIterator
{
    public string $name { get => $this->getTagName(); }
    public string $value { get => $this->getTagValue(); }
    public string $textContent { get => $this->getTextContent(); }

    /** @param array<string,string> $attributes List of $attributeName => $attributeValue */
    public array $attributes { get => $this->getAttributes(); }

    /** @param array<string> List of child XML strings */
    public array $children { get => $this->getChildren(); }

    public private(set) mixed $candidate;

    /** @return string XML string for the specified tag name */
    public function get(string $tagName): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $xmlTags = $this->list($tagName);

        return $xmlTags[0] ?? '';
    }

    /** @return array<string> List of XML strings for the specified tag name */
    public function list(string $tagName): array
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (empty($tagName)) {
            return [];
        }

        $list = [];
        $pointer = 0;
        while ($this->existsTag($tagName, $pointer)) {
            $startPosition = $this->getStartPositionTag($tagName, $pointer);
            $endPosition = $this->getEndPositionTag($tagName, $startPosition);
            $list[] = substr($this->candidate, $startPosition, $endPosition - $startPosition);
            $pointer = $endPosition;
        }

        return $list;
    }

    /** @return Result<XmlIterator|ApiError> */
    public function loadFrom(mixed $candidate): Result
    {
        $validationResponse = (new IsXmlStringValidator)->check($candidate);
        if ($validationResponse->isFailure()) {
            return Result::makeFailure($validationResponse->getError());
        }
        $this->candidate = $candidate;

        return Result::makeSuccess($this);
    }

    private function getTagName(int $offset = 0): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $startPosition = strpos($this->candidate, '<', $offset) + 1;
        $tagNameLength = strcspn($this->candidate, ' >/', $startPosition);
        $tagName = substr($this->candidate, $startPosition, $tagNameLength);

        return $tagName;
    }

    private function getTagValue(): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $tagValue = $this->textContent;
        $children = $this->children;
        foreach ($children as $child) {
            $tagValue = str_replace($child, '', $tagValue);
        }

        return $tagValue;
    }

    private function getTextContent(): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if ($this->isAutoClosedTag($this->name)) {
            return '';
        }

        $xmlInnerStartPosition = $this->getInnerStartPositionTag();
        $xmlInnerEndPosition = $this->getInnerEndPositionTag();

        return substr(
            $this->candidate,
            $xmlInnerStartPosition,
            $xmlInnerEndPosition - $xmlInnerStartPosition + 1
        );
    }

    private function getChildren(): array
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if ($this->isAutoClosedTag($this->name)) {
            return [];
        }

        $childrenList = [];
        $pointer = $this->getInnerStartPositionTag();
        $endPosition = $this->getInnerEndPositionTag();
        while ($pointer < $endPosition) {
            $childName = $this->getTagName($pointer);
            if (empty($childName)) {
                break;
            }

            $childStartPosition = $this->getStartPositionTag($childName, $pointer);
            $childEndPosition = $this->getEndPositionTag($childName, $childStartPosition);
            $childrenList[] = substr(
                $this->candidate,
                $childStartPosition,
                $childEndPosition - $childStartPosition
            );
            $pointer = $childEndPosition;
        }

        return $childrenList;
    }

    private function existsTag(string $tagName, int $offset = 0): bool
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (empty($tagName)) {
            throw new Exception('Tag name cannot be empty.');
        }

        $xmlTag = '<' . $tagName;

        return (bool) strpos($this->candidate, $xmlTag, $offset);
    }

    private function getStartPositionTag(string $tagName, int $offset = 0): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (! $this->existsTag($tagName, $offset)) {
            return $this->getInnerEndPositionTag();
        }
        $pattern = '<' . $tagName;
        $pointer = strpos($this->candidate, $pattern, $offset);

        if (in_array($this->candidate[$pointer + strlen($pattern)], [' ', '>', '/'])) {
            return (int) $pointer;
        }

        return $this->getStartPositionTag($tagName, $pointer + strlen($pattern));
    }

    private function getEndPositionTag(string $tagName, int $offset): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if ($this->isAutoClosedTag($tagName, $offset)) {
            return (int) strpos($this->candidate, '/>', $offset) + strlen('/>');
        }

        $xmlTag = '</' . $tagName . '>';

        return (int) strpos($this->candidate, $xmlTag, $offset) + strlen($xmlTag);
    }

    private function getInnerStartPositionTag(): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        return (int) strpos($this->candidate, '>', 0) + 1;
    }

    private function getInnerEndPositionTag(): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if ($this->isAutoClosedTag($this->name)) {
            return $this->getInnerStartPositionTag();
        }

        return (int) strrpos($this->candidate, '</') - 1;
    }

    private function getAttributes(): array
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (! $this->hasAttributes()) {
            return [];
        }

        return $this->sliceCandidate(0, strpos($this->candidate, '>', 0))
            |>(fn ($str) => substr($str, (strpos($str, ' ', 0) + 1), strlen($str)))
            |>(fn ($str) => substr($str, 0, strrpos($str, '"') + 1))
            |>(fn ($str) => str_replace('"', '', $str))
            |>(fn ($str) => trim($str))
            |>(fn ($str) => explode(' ', $str))
            |>(fn ($arr) => array_reduce($arr, function ($acc, $rawAttribute) {
                $rawAttribute = explode('=', $rawAttribute);
                $acc[$rawAttribute[0]] = $rawAttribute[1];

                return $acc;
            }, []));
    }

    private function sliceCandidate(int $startPosition, int $endPosition): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        return (string) substr(
            $this->candidate,
            $startPosition,
            $endPosition - $startPosition + 1
        );
    }

    private function isAutoClosedTag(string $tagName, int $offset = 0): bool
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $pattern = '<' . $tagName;
        $pointer = strpos($this->candidate, $pattern, $offset);
        if ($pointer === false) {
            throw new Exception("Tag <{$tagName}> not found in candidate.");
        }

        $slashPosition = strpos($this->candidate, '/', $pointer);
        $closePosition = strpos($this->candidate, '>', $pointer);

        return $slashPosition < $closePosition;
    }

    private function hasAttributes(): bool
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $openTag = $this->sliceCandidate(0, strpos($this->candidate, '>', 0));

        return strpos($openTag, ' ', 0) !== false;
    }
}
