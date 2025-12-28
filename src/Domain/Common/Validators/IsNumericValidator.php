<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotNumericError;

final class IsNumericValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_numeric($candidate)) {
            return Result::makeFailure(new IsNotNumericError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
