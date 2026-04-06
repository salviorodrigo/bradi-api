<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsCodigoMunicipioValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator;
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure() || ! $this->validateCheckDigit($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('city code is invalid.'));
        }

        return Result::makeSuccess();
    }

    private function validateCheckDigit(string $candidate): bool
    {
        if ($candidate === '9999999') { // Exterior
            return true;
        }

        $totalMod10 = 0;
        for ($digitPosition = 0; $digitPosition < strlen($candidate) - 1; $digitPosition++) {
            $sum = (int) $candidate[$digitPosition];
            if ($digitPosition % 2 != 0) {
                $sum *= 2;
            }
            if ($sum > 9) {
                $sum = intdiv($sum, 10) + ($sum % 10);
            }
            $totalMod10 += $sum;
        }

        $totalMod10 = $totalMod10 % 10;
        $totalMod10 = 10 - $totalMod10;

        return ($totalMod10 % 10) == $candidate[-1];
    }
}
// TODO Make test file.
