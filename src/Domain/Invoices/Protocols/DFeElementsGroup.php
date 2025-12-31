<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithValueError;

abstract class DFeElementsGroup extends DFeElement
{
    public static function validateTagValue(string $tagValue): Result
    {
        if ($tagValue != '') {
            return Result::makeFailure(
                new ValidationError([
                    new XmlElementWithValueError(static::$tagName),
                ])
            );
        }

        return Result::makeSuccess();
    }
}
