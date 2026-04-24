<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;
use UnexpectedValueException;

final class HasNoChildrenValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        if (count($candidate->children()->records) > 0) {
            return Result::makeFailure(new UnexpectedValueException('cannot contain child elements.'));
        }

        return Result::makeSuccess();
    }
}
