<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Traits;

use BradiNfeApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\FieldURI;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\ValueObjects\Source;
use UnexpectedValueException;

trait ValidatesDFeValueElement
{
    protected static function validateTagElements(string $xmlString, string $fieldURI, string $method): Result
    {
        $children = self::xmlParser($xmlString)->listChildren();
        if (count($children) > 0) {
            $detail = new Detail(
                FieldURI::from($fieldURI),
                Source::from($method),
                Input::from($xmlString),
                [new UnexpectedValueException('cannot contain child elements.')]
            );

            return Result::makeFailure(new UnprocessableEntityError($detail));
        }

        return Result::makeSuccess();
    }

    protected static function validateTagAttributes(string $xmlString, string $fieldURI, string $method): Result
    {
        $attributes = self::xmlParser($xmlString)->listAttributes();
        if (count($attributes) > 0) {
            $detail = new Detail(
                FieldURI::from($fieldURI),
                Source::from($method),
                Input::from($xmlString),
                [new UnexpectedValueException('cannot contain attributes.')]
            );

            return Result::makeFailure(new UnprocessableEntityError($detail));
        }

        return Result::makeSuccess();
    }
}
