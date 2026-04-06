<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsCNPJValidator implements Validator
{
    private const WEIGHT_12 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_13 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    public function check(mixed $candidate): Result
    {
        $typeValidationResult = $this->validateType($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new InvalidArgumentException('must be a brazilian CNPJ.'));
        }

        $candidate = (string) $candidate;
        $structureValidationResult = $this->validateStructure($candidate);
        if ($structureValidationResult->isFailure()) {
            return $structureValidationResult;
        }

        $checkDigitValidationResponse = $this->validateCheckDigits($candidate);
        if ($checkDigitValidationResponse->isFailure()) {
            return $checkDigitValidationResponse;
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator(true);

        return $typeValidator->check($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        if (! (bool) preg_match('/^(?!([0-9])\1{13}$)\d{14}$/', $candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must contain 14 digits.'));
        }

        return Result::makeSuccess();
    }

    private function validateCheckDigits(string $candidate): Result
    {
        $first12CnpjChars = substr($candidate, 0, 12);
        $first13CnpjChars = substr($candidate, 0, 13);
        $firstDigit = $this->calcVerificationDigit($first12CnpjChars, self::WEIGHT_12);
        $secondDigit = $this->calcVerificationDigit($first13CnpjChars, self::WEIGHT_13);
        if (substr($candidate, 12, 2) !== strval($firstDigit . $secondDigit)) {
            return Result::makeFailure(new InvalidArgumentException('invalid check digits.'));
        }

        return Result::makeSuccess();
    }

    private function calcVerificationDigit(string $candidate, array $weight): int
    {
        $digits = str_split($candidate);
        $total = 0;
        foreach ($digits as $position => $digit) {
            $total += $digit * $weight[$position];
        }

        $mod11 = $total % 11;

        return ($mod11 < 2) ? 0 : 11 - $mod11;
    }
}

// TODO Make test file.
