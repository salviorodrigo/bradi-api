<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\TooShortStringError;

final class MinStringLengthValidator extends Validator
{
    public function __construct(public readonly string $fieldName, public readonly int $maxStringLength) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_string($candidate) || strlen($candidate) < $this->maxStringLength) {
            return Result::makeFailure(new TooShortStringError($this->fieldName, $this->maxStringLength));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
