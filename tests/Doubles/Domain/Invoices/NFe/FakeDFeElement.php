<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class FakeDFeElement extends DFeElement
{
    public static string $tagName = 'FakeTag';

    public readonly string $value;
    public readonly string $xmlString;

    public function __construct($tagName = 'FakeTag', $value = 'fakeValue')
    {
        self::$tagName = $tagName;
        $this->value = $value;
        $this->xmlString = "<{$tagName}>{$value}</{$tagName}>";
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(new self);
    }

    public static function create(string $value, array $elements = [], array $attributes = [], string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(new self);
    }

    protected static function validateTagValue(string $value, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(null);
    }

    protected static function validateTagAttributes(string $xmlString, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(null);
    }

    protected static function validateTagElements(string $xmlString, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(null);
    }
}
