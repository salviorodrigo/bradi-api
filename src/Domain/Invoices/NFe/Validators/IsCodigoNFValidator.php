<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use UnexpectedValueException;

final class IsCodigoNFValidator implements Validator
{
    public function check(mixed $candidate): Result
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

    private function validateType(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator;

        return $typeValidator->check($candidate);
    }

    private function validateStructure(string $candidate): Result
    {
        $numericValidatorResponse = (new IsNumericValidator(allowLeadingZeros: true))->check($candidate);
        if ($numericValidatorResponse->isFailure()) {
            return $numericValidatorResponse;
        }

        $lengthValidatorResponse = (new StringLengthValidator(stringLength: 8))->check($candidate);
        if ($lengthValidatorResponse->isFailure()) {
            return $lengthValidatorResponse;
        }

        return Result::makeSuccess();
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

        return Result::makeFailure(new UnexpectedValueException(
            'cannot be a sequential numeric series.'
        ));
    }

    private function validateRepeatedDigits(string $candidate): Result
    {
        $digits = str_split($candidate);
        for ($i = 0; $i < count($digits) - 1; $i++) {
            if (intval($digits[$i + 1]) !== intval($digits[$i])) {
                return Result::makeSuccess();
            }
        }

        return Result::makeFailure(new UnexpectedValueException(
            'cannot contain all repeated digits.'
        ));
    }
}
