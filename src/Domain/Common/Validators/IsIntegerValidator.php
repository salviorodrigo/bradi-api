<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

class IsIntegerValidator implements Validator
{
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

        return Result::makeSuccess();
    }

    private function validateStructure(string $candidate): Result
    {
        if (! preg_match('/^[-+]?\d+$/', $candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be an integer.'));
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator;

        return $typeValidator->check($candidate);
    }
}
