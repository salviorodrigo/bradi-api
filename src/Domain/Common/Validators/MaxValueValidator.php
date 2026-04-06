<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use OutOfRangeException;

final class MaxValueValidator implements Validator
{
    public function __construct(
        public readonly float $maxValue
    ) {}

    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator(true);
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure() || (float) $candidate > $this->maxValue) {
            return Result::makeFailure(new OutOfRangeException(sprintf(
                'cannot be greater than %s.',
                $this->maxValue
            )));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
