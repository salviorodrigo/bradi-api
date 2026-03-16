<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Invoices\Exceptions\InvalidDigitoCodigoMunicipioError;

final class IsCodigoMunicipioValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator($this->fieldURI, $this->source);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure() || ! $this->validateCheckDigit($candidate)) {
            return Result::makeFailure(new InvalidDigitoCodigoMunicipioError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
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
