<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidDecimalNumberError;

class IsDecimalValidator extends Validator
{
    public function __construct(
        public readonly string $fieldName,
        private readonly int $maxIntegerDigits,
        private readonly int $maxDecimalDigits,
    ) {}

    public function validate(mixed $candidate): Result
    {
        $numericValidatorResponse = (new IsNumericValidator($this->fieldName))->validate($candidate);
        if (! $numericValidatorResponse->isSuccess()) {
            return $numericValidatorResponse;
        }

        $parts = explode('.', $candidate);
        $integerPart = $parts[0];
        $decimalPart = $parts[1] ?? '';

        if (
            strlen($integerPart) > $this->maxIntegerDigits ||
            strlen($decimalPart) > $this->maxDecimalDigits ||
            ! preg_match('/^-?\d+(\.\d+)?$/', $candidate) // The regex allows for an optional negative sign, followed by digits, and an optional decimal part.
        ) {
            return Result::makeFailure(new InvalidDecimalNumberError($this->fieldName, $this->maxIntegerDigits, $this->maxDecimalDigits));
        }

        return Result::makeSuccess();
    }
}
