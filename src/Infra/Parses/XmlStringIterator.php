<?php

declare(strict_types=1);

namespace BradiApi\Infra\Parses;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\Protocols\XmlIterator;
use Exception;
use Generator;

final class XmlStringIterator implements XmlIterator
{
    public string $name { get => $this->getTagName(); }
    public string $value { get => $this->getTagValue(); }
    public string $textContent { get => $this->getTextContent(); }

    /** @param array<string,string> $attributes List of $attributeName => $attributeValue */
    public array $attributes { get => $this->getAttributes(); }

    /** @param iterable<string> List of child XML strings */
    public iterable $children { get => $this->getChildren(); }

    public private(set) mixed $candidate;

    /** @return string XML string for the specified tag name */
    public function get(string $tagName): string
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        return $this->list($tagName)->current() ?? '';
    }

    /** @return iterable<string> List of XML strings for the specified tag name */
    public function list(string $tagName): Generator
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (empty($tagName)) {
            return [];
        }

        $pointer = 0;
        while ($this->existsTag($tagName, $pointer)) {
            $startPosition = $this->getStartPositionTag($tagName, $pointer);
            $endPosition = $this->getEndPositionTag($tagName, $startPosition);
            yield substr($this->candidate, $startPosition, $endPosition - $startPosition);
            $pointer = $endPosition;
        }
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

    private function getChildren(): Generator
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
            yield substr(
                $this->candidate,
                $childStartPosition,
                $childEndPosition - $childStartPosition
            );
            $pointer = $childEndPosition;
        }
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

        return strpos($this->candidate, $xmlTag, $offset) !== false;
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

        $startPosition = $this->getStartPositionTag($tagName, $offset);

        if ($this->isAutoClosedTag($tagName, $startPosition)) {
            return $this->getPositionAfterTagOpen($startPosition);
        }

        return $this->getPositionAfterMatchingCloseTag($tagName, $startPosition);
    }

    private function getPositionAfterMatchingCloseTag(string $tagName, int $startPosition): int
    {
        $closingTag = '</' . $tagName . '>';
        $pointer = $this->getPositionAfterTagOpen($startPosition);
        $openDepth = 1;

        while ($openDepth > 0) {
            $nextOpenPosition = $this->getNextStartPositionTag($tagName, $pointer);
            $nextClosePosition = strpos($this->candidate, $closingTag, $pointer);
            if ($nextClosePosition === false) {
                throw new Exception("Closing tag </{$tagName}> not found.");
            }

            $opensBeforeCloses = $nextOpenPosition !== false && $nextOpenPosition < $nextClosePosition;
            if ($opensBeforeCloses) {
                $openDepth += $this->isAutoClosedTag($tagName, $nextOpenPosition) ? 0 : 1;
                $pointer = $this->getPositionAfterTagOpen($nextOpenPosition);

                continue;
            }

            $openDepth--;
            $pointer = $nextClosePosition + strlen($closingTag);
        }

        return $pointer;
    }

    private function getPositionAfterTagOpen(int $offset): int
    {
        return (int) strpos($this->candidate, '>', $offset) + 1;
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

        $openTag = $this->getOpenTag($tagName, $offset);

        return preg_match('/\/\s*>$/', $openTag) === 1;
    }

    private function getOpenTag(string $tagName, int $offset = 0): string
    {
        $startPosition = strpos($this->candidate, '<' . $tagName, $offset);
        if ($startPosition === false) {
            throw new Exception("Tag <{$tagName}> not found in candidate.");
        }

        $closePosition = strpos($this->candidate, '>', $startPosition);
        if ($closePosition === false) {
            throw new Exception("Tag <{$tagName}> is not properly closed.");
        }

        return substr($this->candidate, $startPosition, $closePosition - $startPosition + 1);
    }

    private function getNextStartPositionTag(string $tagName, int $offset): int|false
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $pattern = '<' . $tagName;
        $pointer = $offset;

        while (($position = strpos($this->candidate, $pattern, $pointer)) !== false) {
            $charAfterTagName = $this->candidate[$position + strlen($pattern)] ?? '';
            if (in_array($charAfterTagName, [' ', '>', '/'], true)) {
                return $position;
            }

            $pointer = $position + strlen($pattern);
        }

        return false;
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
