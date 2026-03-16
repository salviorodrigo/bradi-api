<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\ForbiddenCharsError;
use BradiNfeApi\Domain\Common\Exceptions\InvalidTypeError;
use BradiNfeApi\Domain\Common\Exceptions\LeadingZerosError;
use BradiNfeApi\Domain\Common\Exceptions\TooManyDecimalSeparatorError;

final class IsNumericValidator extends Validator
{
    private string $negativeCharacter = '-';
    private string $positiveCharacter = '+';

    public function __construct(
        public readonly string $field,
        public readonly string $source,
        public readonly bool $allowLeadingZeros = false,
        public readonly string $decimalSeparator = '.',
        public readonly string $thousandsSeparator = ','
    ) {}

    public function validate(mixed $candidate): Result
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
            return Result::makeFailure(new InvalidTypeError(
                $this->field,
                $this->source,
                $candidate,
                'numeric'
            ));
        }

        return Result::makeSuccess();
    }

    private function validateStructure(string $candidate): Result
    {
        $textFormatValidator = new TextFormatValidator($this->field, $this->source);
        $textFormatValidationResponse = $textFormatValidator->validate($candidate);
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
            return Result::makeFailure(new LeadingZerosError(
                $this->field,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }

    private function validateDecimalSeparator(string $candidate): Result
    {
        if (substr_count($candidate, $this->decimalSeparator) > 1) {
            return Result::makeFailure(new TooManyDecimalSeparatorError(
                $this->field,
                $this->source,
                $candidate,
                $this->decimalSeparator
            ));
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
            return Result::makeFailure(new ForbiddenCharsError(
                $this->field,
                $this->source,
                $candidate,
                $forbiddenChars
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
