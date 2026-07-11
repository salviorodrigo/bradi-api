<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Xml;

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\Protocols\XmlIterator;

final class FakeXmlIterator implements XmlIterator
{
    public mixed $candidate { get => null; }

    public string $name { get => ''; }

    public string $value { get => ''; }

    public string $textContent { get => ''; }

    public array $attributes { get => []; }

    public array $children { get => []; }

    public function get(string $tagName): string
    {
        return '';
    }

    public function list(string $tagName): array
    {
        return [];
    }

    public function loadFrom(mixed $candidate): Result
    {
        return Result::makeSuccess($this);
    }
}
