<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\Services\ValidationService;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\ForbiddenRepeatedCharsError;
use BradiNfeApi\Domain\Common\Exceptions\ForbiddenSequentialNumberError;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;

final class IsCodigoNFValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidatorResponse = $this->validateType($candidate);
        if ($typeValidatorResponse->isFailure()) {
            return $typeValidatorResponse;
        }

        $structureValidatorResponse = $this->validateStructure((string) $candidate);
        if ($structureValidatorResponse->isFailure()) {
            return $structureValidatorResponse;
        }

        $sequentialDigitsValidationResponse = $this->validateSequentialDigits((string) $candidate);
        if ($sequentialDigitsValidationResponse->isFailure()) {
            return $sequentialDigitsValidationResponse;
        }

        $repeatedDigitsValidationResponse = $this->validateRepeatedDigits((string) $candidate);
        if ($repeatedDigitsValidationResponse->isFailure()) {
            return $repeatedDigitsValidationResponse;
        }

        return Result::makeSuccess();
    }

    private function validateType(string $candidate): Result
    {
        $typeValidator = new IsNumericValidator($this->fieldURI, $this->source);

        return $typeValidator->validate($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        $lengthValidator = new ValidationService([
            IsNumericValidator::class => ['allowLeadingZeros' => true],
            StringLengthValidator::class => [8],
        ], $this->fieldURI, $this->source);

        return $lengthValidator->verify($candidate);

        $sequentialDigitsValidationResponse = $this->validateSequentialDigits((string) $candidate);
        if ($sequentialDigitsValidationResponse->isFailure()) {
            return $sequentialDigitsValidationResponse;
        }

        $repeatedDigitsValidationResponse = $this->validateRepeatedDigits((string) $candidate);
        if ($repeatedDigitsValidationResponse->isFailure()) {
            return $repeatedDigitsValidationResponse;
        }
    }

    private function validateSequentialDigits(string $candidate): Result
    {
        $digits = str_split($candidate);
        for ($i = 0; $i < count($digits) - 1; $i++) {
            if (intval($digits[$i]) === 9 && intval($digits[$i + 1]) !== 0) {
                return Result::makeSuccess();
            }

            if (intval($digits[$i + 1]) - intval($digits[$i]) !== 1) {
                return Result::makeSuccess();
            }
        }

        return Result::makeFailure(
            new ForbiddenSequentialNumberError(
                $this->fieldURI,
                $this->source,
                $candidate
            )
        );
    }

    private function validateRepeatedDigits(string $candidate): Result
    {
        $digits = str_split($candidate);
        for ($i = 0; $i < count($digits) - 1; $i++) {
            if (intval($digits[$i + 1]) !== intval($digits[$i])) {
                return Result::makeSuccess();
            }
        }

        return Result::makeFailure(
            new ForbiddenRepeatedCharsError(
                $this->fieldURI,
                $this->source,
                $candidate
            )
        );
    }
}

// TODO Make test file.
