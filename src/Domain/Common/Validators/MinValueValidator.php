<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\LessThanError;

final class MinValueValidator extends Validator
{
    public function __construct(public readonly string $fieldName, public readonly float $minValue) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_numeric($candidate) || (float) $candidate < $this->minValue) {
            return Result::makeFailure(new LessThanError($this->fieldName, $this->minValue));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
