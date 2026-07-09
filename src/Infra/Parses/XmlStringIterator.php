<?php

declare(strict_types=1);

namespace BradiNfeApi\Infra\Parses;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\Protocols\XmlIterator;
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

    public function __construct(
        private readonly string $encode = 'UTF-8'
    ) {}

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

        $tagName = '';
        $startPosition = iconv_strpos($this->candidate, '<', $offset);
        for ($i = $startPosition + 1; $i < strlen($this->candidate); $i++) {
            if ($this->candidate[$i] == ' ' || $this->candidate[$i] == '>' || $this->candidate[$i] == '/') {
                break;
            }

            $tagName .= $this->candidate[$i];
        }

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
        while ($pointer < $this->getInnerEndPositionTag()) {
            $childName = $this->getTagName($pointer);
            if (empty($childName)) {
                break;
            }

            $childStartPosition = $this->getStartPositionTag($childName, $pointer);
            $childEndPosition = $this->getEndPositionTag($childName, $childStartPosition);
            $childrenList[$childName] = substr(
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
            return false;
        }

        $xmlTag = '<' . $tagName;
        $startPosition = iconv_strpos($this->candidate, $xmlTag, $offset);
        if ($startPosition === false) {
            return false;
        }

        if ($this->candidate[$startPosition + strlen($xmlTag)] != ' '
             && $this->candidate[$startPosition + strlen($xmlTag)] != '>'
             && $this->candidate[$startPosition + strlen($xmlTag)] != '/') {
            return $this->existsTag($tagName, $startPosition + strlen($xmlTag));
        }

        return true;
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
        $pointer = iconv_strpos($this->candidate, $pattern, $offset, $this->encode);

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
            return (int) iconv_strpos($this->candidate, '/>', $offset, $this->encode) + strlen('/>');
        }

        $xmlTag = '</' . $tagName . '>';

        return (int) iconv_strpos($this->candidate, $xmlTag, $offset, $this->encode) + strlen($xmlTag);
    }

    private function getInnerStartPositionTag(): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        return (int) iconv_strpos($this->candidate, '>', 0, $this->encode) + 1;
    }

    private function getInnerEndPositionTag(): int
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if ($this->isAutoClosedTag($this->name)) {
            return $this->getInnerStartPositionTag();
        }

        return (int) iconv_strrpos($this->candidate, '</', encoding: $this->encode) - 1;
    }

    private function getAttributes(): array
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        if (! $this->hasAttributes()) {
            return [];
        }

        return $this->sliceCandidate(0, iconv_strpos($this->candidate, '>', 0, $this->encode))
            |>(fn ($str) => iconv_substr($str, (iconv_strpos($str, ' ', 0, $this->encode) + 1), strlen($str), $this->encode))
            |>(fn ($str) => iconv_substr($str, 0, iconv_strrpos($str, '"', $this->encode) + 1, $this->encode))
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

        return (string) iconv_substr(
            $this->candidate,
            $startPosition,
            $endPosition - $startPosition + 1,
            $this->encode
        );
    }

    private function isAutoClosedTag(string $tagName, int $offset = 0): bool
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $pattern = '<' . $tagName;
        $pointer = iconv_strpos($this->candidate, $pattern, $offset);
        if ($pointer === false) {
            return false;
        }

        if ($this->candidate[$pointer + strlen($pattern)] != ' '
             && $this->candidate[$pointer + strlen($pattern)] != '>'
             && $this->candidate[$pointer + strlen($pattern)] != '/') {
            return $this->isAutoClosedTag($tagName, $pointer + strlen($pattern));
        }

        return $this->candidate[iconv_strpos($this->candidate, '>', $pointer) - 1] == '/';
    }

    private function hasAttributes(): bool
    {
        if (! isset($this->candidate)) {
            throw new Exception('Candidate not loaded.');
        }

        $openTag = $this->sliceCandidate(0, iconv_strpos($this->candidate, '>', 0, $this->encode));

        return iconv_strpos($openTag, ' ', 0, $this->encode) !== false;
    }
}
