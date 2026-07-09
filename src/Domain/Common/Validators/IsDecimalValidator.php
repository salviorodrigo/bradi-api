<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;
use LengthException;

class IsDecimalValidator implements Validator
{
    public function __construct(
        public readonly int $maxIntegerDigits,
        public readonly int $maxDecimalDigits,
    ) {}

    public function check(mixed $candidate): Result
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
        $typeValidator = new IsNumericValidator;

        return $typeValidator->check($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        // The regex allows for an optional negative sign, followed by digits, and an optional decimal part.
        if (! preg_match('/^-?\d+(\.\d+)?$/', $candidate)) {
            return Result::makeFailure(new InvalidArgumentException(sprintf(
                'must be a decimal number with up to %d integer digits and %d decimal digits.',
                $this->maxIntegerDigits,
                $this->maxDecimalDigits
            )));
        }

        return Result::makeSuccess();
    }

    private function validateIntegerPart(string $integerPart, string $candidate): Result
    {
        if (strlen($integerPart) > $this->maxIntegerDigits) {
            return Result::makeFailure(new LengthException(sprintf(
                'integer part cannot contain more than %d digits.',
                $this->maxIntegerDigits
            )));
        }

        return Result::makeSuccess();
    }

    private function validateDecimalPart(string $decimalPart, string $candidate): Result
    {
        if (strlen($decimalPart) > $this->maxDecimalDigits) {
            return Result::makeFailure(new LengthException(sprintf(
                'decimal part cannot contain more than %d digits.',
                $this->maxDecimalDigits
            )));
        }

        return Result::makeSuccess();
    }
}
