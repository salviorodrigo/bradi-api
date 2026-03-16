<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\InvalidStringLengthError;

final class StringLengthValidator extends Validator
{
    public readonly array $stringLengths;

    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        int ...$stringLength
    ) {
        $this->stringLengths = (array) $stringLength;
    }

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator($this->fieldURI, $this->source);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new InvalidStringLengthError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->stringLengths
            ));
        }

        if (! array_find($this->stringLengths, fn ($stringLength) => strlen($candidate) === $stringLength)) {
            return Result::makeFailure(new InvalidStringLengthError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->stringLengths
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
