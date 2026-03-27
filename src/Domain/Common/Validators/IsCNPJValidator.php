<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\InvalidCNPJCheckDigitError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidCNPJError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidCNPJStructureError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class IsCNPJValidator extends Validator
{
    private const WEIGHT_12 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_13 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    public function __construct(public readonly string $field, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidationResult = $this->validateType($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new InvalidCNPJError(
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

        $checkDigitValidationResponse = $this->validateCheckDigits($candidate);
        if ($checkDigitValidationResponse->isFailure()) {
            return $checkDigitValidationResponse;
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
        if (! (bool) preg_match('/^(?!([0-9])\1{13}$)\d{14}$/', $candidate)) {
            return Result::makeFailure(new InvalidCNPJStructureError(
                $this->field,
                $this->source,
                $candidate
            ));
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
            return Result::makeFailure(new InvalidCNPJCheckDigitError(
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
