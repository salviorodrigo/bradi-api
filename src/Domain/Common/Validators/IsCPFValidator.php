<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\InvalidCPFCheckDigitError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidCPFError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidCPFStructureError;

final class IsCPFValidator extends Validator
{
    private const WEIGHT_10 = [10, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_11 = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];

    public function __construct(public readonly string $field, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidationResult = $this->validateType($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new InvalidCPFError(
                $this->field,
                $this->source,
                $candidate
            ));
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
        $typeValidator = new IsNumericValidator($this->field, $this->source, true);

        return $typeValidator->validate($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        if (! (bool) preg_match('/^(?!([0-9])\1{10}$)\d{11}$/', $candidate)) {
            return Result::makeFailure(new InvalidCPFStructureError(
                $this->field,
                $this->source,
                $candidate
            ));
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
            return Result::makeFailure(new InvalidCPFCheckDigitError(
                $this->field,
                $this->source,
                $candidate
            ));
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
