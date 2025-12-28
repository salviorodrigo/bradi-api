<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidVerificationDigitError;

final class Mod10Validator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        $totalBase2 = 0;
        for ($pointer = 0; $pointer < strlen($candidate) - 1; $pointer++) {
            $totalBase2 += (int) $candidate[$pointer];
            if ($pointer % 2 != 0) {
                $totalBase2 += (int) $candidate[$pointer];
            }
        }
        if (($totalBase2 % 10) != $candidate[-1]) {
            return Result::makeFailure(new InvalidVerificationDigitError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
