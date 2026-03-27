<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Common\Exceptions\XmlElementWithValueError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

abstract class DFeGroupElement extends DFeElement
{
    protected static function validateTagValue(string $xmlString, string $fieldURI, string $method): Result
    {
        $textContent = self::xmlParser($xmlString)->getTextContent();
        if ($textContent != '') {
            return Result::makeFailure(
                new XmlElementWithValueError($fieldURI, $method, $textContent),
            );
        }

        return Result::makeSuccess();
    }

    protected static function validateTagAttributes(string $xmlString, string $fieldURI, string $method): Result
    {
        $attributes = self::xmlParser($xmlString)->listAttributes();
        if (count($attributes) > 0) {
            return Result::makeFailure(
                new XmlElementWithAttributesError($fieldURI, $method, $attributes),
            );
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
