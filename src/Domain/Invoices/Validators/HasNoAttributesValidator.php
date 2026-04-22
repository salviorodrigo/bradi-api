<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use UnexpectedValueException;

final class HasNoAttributesValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (is_array($candidate) && count($candidate) > 0) {
            return Result::makeFailure(new UnexpectedValueException('cannot contain attributes.'));
        }

        return Result::makeSuccess();
    }
}
