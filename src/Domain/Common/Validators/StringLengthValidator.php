<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidStringLengthError;

final class StringLengthValidator extends Validator
{
    public function __construct(public readonly string $fieldName, public readonly int $stringLength) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_string($candidate) || strlen($candidate) != $this->stringLength) {
            return Result::makeFailure(new InvalidStringLengthError($this->fieldName, $this->stringLength));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
