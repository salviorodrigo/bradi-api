<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\GreatThanError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidDecimalNumberError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

class IsDecimalValidator extends Validator
{
    public function __construct(
        public readonly string $field,
        public readonly string $source,
        public readonly int $maxIntegerDigits,
        public readonly int $maxDecimalDigits,
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidationResponse = $this->validateType($candidate);
        if (! $typeValidationResponse->isSuccess()) {
            return $typeValidationResponse;
        }

        $structureValidationResponse = $this->validateStructure((string) $candidate);
        if (! $structureValidationResponse->isSuccess()) {
            return $structureValidationResponse;
        }

        $parts = explode('.', $candidate);
        $integerPart = $parts[0];
        $decimalPart = $parts[1] ?? '';
        $integerPartValidationResponse = $this->validateIntegerPart($integerPart, $candidate);
        if (! $integerPartValidationResponse->isSuccess()) {
            return $integerPartValidationResponse;
        }

        $decimalPartValidationResponse = $this->validateDecimalPart($decimalPart, $candidate);
        if (! $decimalPartValidationResponse->isSuccess()) {
            return $decimalPartValidationResponse;
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator($this->field, $this->source);

        return $typeValidator->validate($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        // The regex allows for an optional negative sign, followed by digits, and an optional decimal part.
        if (! preg_match('/^-?\d+(\.\d+)?$/', $candidate)) {
            return Result::makeFailure(new InvalidDecimalNumberError(
                $this->field,
                $this->source,
                $candidate,
                $this->maxIntegerDigits,
                $this->maxDecimalDigits
            ));
        }

        return Result::makeSuccess();
    }

    private function validateIntegerPart(string $integerPart, string $candidate): Result
    {
        if (strlen($integerPart) > $this->maxIntegerDigits) {
            return Result::makeFailure(new GreatThanError(
                $this->field,
                $this->source,
                $candidate,
                (float) str_repeat('9', $this->maxIntegerDigits),
            ));
        }

        return Result::makeSuccess();
    }

    private function validateDecimalPart(string $decimalPart, string $candidate): Result
    {
        if (strlen($decimalPart) > $this->maxDecimalDigits) {
            return Result::makeFailure(new GreatThanError(
                $this->field,
                $this->source,
                $candidate,
                (float) ('0.' . str_repeat('9', $this->maxDecimalDigits)),
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file (with negative numbers).
