<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class FormatDataHoraTZDValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator;
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure()
            || ! preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])T([01]\d|2[0-3]):[0-5]\d:[0-5]\d([+-]\d{2}:\d{2})$/', $candidate)) {
            return Result::makeFailure(new InvalidArgumentException(
                'The value must match the YYYY-MM-DDTHH:mm:ss+00:00 format.'
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
