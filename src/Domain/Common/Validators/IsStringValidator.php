<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
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
