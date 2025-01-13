<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNullError;

final class NotNullValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! isset($candidate) || $candidate == '' || $candidate == []) {
            return Result::makeFailure(new IsNullError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}
