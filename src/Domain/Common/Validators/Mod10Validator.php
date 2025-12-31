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
        $totalMod10 = 0;
        for ($digitPosition = 0; $digitPosition < strlen($candidate) - 1; $digitPosition++) {
            $sum = (int) $candidate[$digitPosition];
            if ($digitPosition % 2 != 0) {
                $sum *= 2;
            }
            if ($sum > 9) {
                $sum = intdiv($sum, 10) + ($sum % 10);
            }
            $totalMod10 += $sum;
        }

        $totalMod10 = $totalMod10 % 10;
        $totalMod10 = 10 - $totalMod10;

        if (($totalMod10 % 10) != $candidate[-1]) {
            return Result::makeFailure(new InvalidVerificationDigitError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}
// TODO Make test file.
