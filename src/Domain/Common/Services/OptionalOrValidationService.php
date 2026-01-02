<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Services;

use BradiNfeApi\Common\Result;

final class OptionalOrValidationService extends ValidationService
{
    public function __construct(array $validators)
    {
        parent::__construct($validators);
    }

    public function verify(mixed $candidate): Result
    {
        if (empty($candidate)) {
            return Result::makeSuccess();
        }

        return parent::verify($candidate);
    }
}

// TODO Make test file.
