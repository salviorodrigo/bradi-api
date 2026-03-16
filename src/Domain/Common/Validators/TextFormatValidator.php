<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\LeadingSpacesError;
use BradiNfeApi\Domain\Common\Exceptions\NestedSpacesError;
use BradiNfeApi\Domain\Common\Exceptions\TrailingSpacesError;

final class TextFormatValidator extends Validator
{
    public function __construct(public readonly string $fieldURI, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator($this->fieldURI, $this->source);
        $typeValidatorResponse = $typeValidator->validate($candidate);
        if ($typeValidatorResponse->isFailure()) {
            return $typeValidatorResponse;
        }

        if ($this->hasLeadingSpaces($candidate)) {
            return Result::makeFailure(new LeadingSpacesError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        if ($this->hasTrailingSpaces($candidate)) {
            return Result::makeFailure(new TrailingSpacesError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        if ($this->hasNestedSpaces($candidate)) {
            return Result::makeFailure(new NestedSpacesError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
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
