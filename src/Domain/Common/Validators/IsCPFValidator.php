<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsCPFValidator implements Validator
{
    private const WEIGHT_10 = [10, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_11 = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];

    public function check(mixed $candidate): Result
    {
        $typeValidationResult = $this->validateType($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new InvalidArgumentException('must be a brazilian CPF.'));
        }

        $candidate = (string) $candidate;
        $structureValidationResult = $this->validateStructure($candidate);
        if ($structureValidationResult->isFailure()) {
            return $structureValidationResult;
        }

        $checkDigitValidationResult = $this->validateCheckDigits($candidate);
        if ($checkDigitValidationResult->isFailure()) {
            return $checkDigitValidationResult;
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
        if (! (bool) preg_match('/^(?!([0-9])\1{10}$)\d{11}$/', $candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must contain 11 digits.'));
        }

        return Result::makeSuccess();
    }

    private function validateCheckDigits(string $candidate): Result
    {
        $first9CpfChars = substr($candidate, 0, 9);
        $first10CpfChars = substr($candidate, 0, 10);
        $firstDigit = $this->calcVerificationDigit($first9CpfChars, self::WEIGHT_10);
        $secondDigit = $this->calcVerificationDigit($first10CpfChars, self::WEIGHT_11);
        if (substr($candidate, 9, 2) !== strval($firstDigit . $secondDigit)) {
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
