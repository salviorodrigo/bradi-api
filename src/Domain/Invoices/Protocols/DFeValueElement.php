<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Common\Exceptions\XmlElementWithChildElementsError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

abstract class DFeValueElement extends DFeElement
{
    protected static function validateTagElements(string $xmlString, string $fieldURI, string $method): Result
    {
        $children = self::xmlParser($xmlString)->listChildren();
        if (count($children) > 0) {
            return Result::makeFailure(
                new XmlElementWithChildElementsError($fieldURI, $method, $xmlString),
            );
        }

        return Result::makeSuccess();
    }

    protected static function validateTagAttributes(string $xmlString, string $fieldURI, string $method): Result
    {
        $attributes = self::xmlParser($xmlString)->listAttributes();
        if (count($attributes) > 0) {
            return Result::makeFailure(
                new XmlElementWithAttributesError($fieldURI, $method, $xmlString),
            );
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
