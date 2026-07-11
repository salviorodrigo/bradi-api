<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use UnexpectedValueException;

final class TextFormatValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator;
        $typeValidatorResponse = $typeValidator->check($candidate);
        if ($typeValidatorResponse->isFailure()) {
            return $typeValidatorResponse;
        }

        if ($this->hasLeadingSpaces($candidate)) {
            return Result::makeFailure(new UnexpectedValueException('cannot start with spaces.'));
        }

        if ($this->hasTrailingSpaces($candidate)) {
            return Result::makeFailure(new UnexpectedValueException('cannot end with spaces.'));
        }

        if ($this->hasNestedSpaces($candidate)) {
            return Result::makeFailure(new UnexpectedValueException('cannot contain consecutive spaces.'));
        }

        return Result::makeSuccess();
    }

    private function hasLeadingSpaces(string $value): bool
    {
        return str_starts_with($value, ' ');
    }

    private function hasTrailingSpaces(string $value): bool
    {
        return str_ends_with($value, ' ');
    }

    private function hasNestedSpaces(string $value): bool
    {
        return str_contains($value, '  ');
    }
}
