<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsValidCodigoBarrasValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if ($candidate === 'SEM GTIN') {
            return Result::makeSuccess();
        }

        $numericValidator = new IsNumericValidator(allowLeadingZeros: true);

        if ($numericValidator->check($candidate)->isFailure()) {
            return Result::makeFailure(new InvalidArgumentException('barcode must be numeric or "SEM GTIN".'));
        }

        return Result::makeSuccess();
    }
}
