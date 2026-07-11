<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;
use UnexpectedValueException;

final class IsNumericValidator implements Validator
{
    private string $negativeCharacter = '-';
    private string $positiveCharacter = '+';

    public function __construct(
        public readonly bool $allowLeadingZeros = false,
        public readonly string $decimalSeparator = '.',
        public readonly string $thousandsSeparator = ','
    ) {}

    public function check(mixed $candidate): Result
    {
        $typeValidationResponse = $this->validateType($candidate);
        if ($typeValidationResponse->isFailure()) {
            return $typeValidationResponse;
        }

        $structureValidationResponse = $this->validateStructure((string) $candidate);
        if ($structureValidationResponse->isFailure()) {
            return $structureValidationResponse;
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        if (! is_numeric($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be numeric.'));
        }

        return Result::makeSuccess();
    }

    private function validateStructure(string $candidate): Result
    {
        $textFormatValidator = new TextFormatValidator;
        $textFormatValidationResponse = $textFormatValidator->check($candidate);
        if ($textFormatValidationResponse->isFailure()) {
            return $textFormatValidationResponse;
        }

        $leadingZerosValidationResponse = $this->validateLeadingZeros($candidate);
        if ($leadingZerosValidationResponse->isFailure()) {
            return $leadingZerosValidationResponse;
        }

        $validateDecimalSeparatorResponse = $this->validateDecimalSeparator($candidate);
        if ($validateDecimalSeparatorResponse->isFailure()) {
            return $validateDecimalSeparatorResponse;
        }

        $validateAllowedCharsResponse = $this->validateAllowedChars($candidate);
        if ($validateAllowedCharsResponse->isFailure()) {
            return $validateAllowedCharsResponse;
        }

        return Result::makeSuccess();
    }

    private function validateLeadingZeros(string $candidate): Result
    {
        if ((str_starts_with($candidate, '0')
            && (isset($candidate[1]) && $candidate[1] !== '.')
            && ! $this->allowLeadingZeros
        )) {
            return Result::makeFailure(new UnexpectedValueException('cannot contain leading zeros.'));
        }

        return Result::makeSuccess();
    }

    private function validateDecimalSeparator(string $candidate): Result
    {
        if (substr_count($candidate, $this->decimalSeparator) > 1) {
            return Result::makeFailure(new UnexpectedValueException(sprintf(
                'cannot contain more than one decimal separator "%s".',
                $this->decimalSeparator
            )));
        }

        return Result::makeSuccess();
    }

    private function validateAllowedChars(string $candidate): Result
    {
        $allowedChars = array_merge(
            range('0', '9'),
            [$this->decimalSeparator, $this->thousandsSeparator, $this->negativeCharacter, $this->positiveCharacter]
        );

        $forbiddenChars = array_diff(str_split($candidate), $allowedChars);
        if (count($forbiddenChars) > 0) {
            return Result::makeFailure(new UnexpectedValueException(sprintf(
                'The numeric value contains forbidden characters: %s.',
                implode(', ', $forbiddenChars)
            )));
        }

        return Result::makeSuccess();
    }
}
