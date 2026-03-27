<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\TooLongStringError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class MaxStringLengthValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly int $maxStringLength
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator($this->fieldURI, $this->source);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure() || strlen($candidate) > $this->maxStringLength) {
            return Result::makeFailure(new TooLongStringError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->maxStringLength
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
