<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use UnexpectedValueException;

final class HasNoTextContentValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (is_string($candidate) && $candidate !== '') {
            return Result::makeFailure(new UnexpectedValueException('cannot contain text content.'));
        }

        return Result::makeSuccess();
    }
}
