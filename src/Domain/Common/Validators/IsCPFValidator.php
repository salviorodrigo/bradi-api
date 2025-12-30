<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidCNPJError;

final class IsCPFValidator extends Validator
{
    private const WEIGHT_10 = [10, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_11 = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];

    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_numeric($candidate) || ! preg_match('/^(?!([1-9])\1{10}$)\d{11}$/', $candidate)) {
            return Result::makeFailure(new InvalidCNPJError($this->fieldName));
        }

        $first9CpfChars = substr($candidate, 0, 9);
        $first10CpfChars = substr($candidate, 0, 10);
        $firstDigit = $this->calcVerificationDigit($first9CpfChars, self::WEIGHT_10);
        $secondDigit = $this->calcVerificationDigit($first10CpfChars, self::WEIGHT_11);

        if (substr($candidate, 9, 2) != strval($firstDigit . $secondDigit)) {
            return Result::makeFailure(new InvalidCNPJError($this->fieldName));
        }

        return Result::makeSuccess();
    }

    private function calcVerificationDigit(string $candidate, array $weight): int
    {
        $digits = str_split($candidate);
        $total = 0;
        foreach ($digits as $position => $digit) {
            $total += $digit * $weight[$position];
        }
        $mod11 = $total % 11;

        return ($mod11 < 2) ? 0 : 11 - $mod11;
    }
}

// TODO Make test file.
