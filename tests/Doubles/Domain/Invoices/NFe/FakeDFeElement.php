<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class FakeDFeElement extends DFeElement
{
    public static string $tagName = 'FakeTag';

    public function __construct(string $tagName = 'FakeTag', string $value = 'fakeValue')
    {
        self::$tagName = $tagName;
        $this->value = $value;
        $this->xmlString = "<{$tagName}>{$value}</{$tagName}>";
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(new self);
    }

    public static function create(string $tagValue, array $elements, array $attributes, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        return Result::makeSuccess(new self);
    }

    /** @return array<Validator> */
    protected static function tagValueValidators(): array
    {
        return [];
    }

    /** @return array<Validator> */
    protected static function tagAttributesValidators(): array
    {
        return [];
    }

    /** @return array<Validator> */
    protected static function tagElementsValidators(): array
    {
        return [];
    }
}
