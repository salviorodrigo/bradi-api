<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotStringError;

final class IsStringValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_string($candidate)) {
            return Result::makeFailure(new IsNotStringError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}
