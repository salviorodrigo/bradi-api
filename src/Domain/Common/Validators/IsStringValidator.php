<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsStringValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! is_string($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be a string.'));
        }

        return Result::makeSuccess();
    }
}
