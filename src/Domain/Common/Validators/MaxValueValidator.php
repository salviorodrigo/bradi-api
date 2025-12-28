<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\GreatThanError;

final class MaxValueValidator extends Validator
{
    public function __construct(public readonly string $fieldName, public readonly float $maxValue) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_numeric($candidate) || (float) $candidate > $this->maxValue) {
            return Result::makeFailure(new GreatThanError($this->fieldName, $this->maxValue));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
