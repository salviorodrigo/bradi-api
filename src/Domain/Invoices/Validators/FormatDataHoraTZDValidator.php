<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidDateTimeFormatError;

final class FormatDataHoraTZDValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])T([01]\d|2[0-3]):[0-5]\d:[0-5]\d([+-]\d{2}:\d{2})$/', $candidate)) {
            return Result::makeFailure(new InvalidDateTimeFormatError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
