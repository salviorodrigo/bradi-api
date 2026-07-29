<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\Protocols;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Result;

interface XmlIterator
{
    public mixed $candidate {get; }

    public string $name {get; }

    public string $value {get; }

    public string $textContent {get; }

    /** @param array<string,string> $attributes List of $attributeName => $attributeValue */
    public array $attributes {get; }

    /** @return iterable<string> List of child XML strings */
    public iterable $children {get; }

    public function get(string $tagName): string;

    /** @return iterable<string> List of child XML strings */
    public function list(string $tagName): iterable;

    /** @return Result<XmlIterator|ApiError> */
    public function loadFrom(mixed $candidate): Result;
}
