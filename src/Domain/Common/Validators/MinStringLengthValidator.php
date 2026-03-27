<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\TooShortStringError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class MinStringLengthValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly int $minStringLength
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator($this->fieldURI, $this->source);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure() || strlen($candidate) < $this->minStringLength) {
            return Result::makeFailure(new TooShortStringError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->minStringLength
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
