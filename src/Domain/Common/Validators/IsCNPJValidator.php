<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidCNPJError;

final class IsCNPJValidator extends Validator
{
    private const WEIGHT_12 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private const WEIGHT_13 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_numeric($candidate) || ! preg_match('/^(?!([1-9])\1{13}$)\d{14}$/', $candidate)) {
            return Result::makeFailure(new InvalidCNPJError($this->fieldName));
        }

        $first12CnpjChars = substr($candidate, 0, 12);
        $first13CnpjChars = substr($candidate, 0, 13);
        $firstDigit = $this->calcVerificationDigit($first12CnpjChars, self::WEIGHT_12);
        $secondDigit = $this->calcVerificationDigit($first13CnpjChars, self::WEIGHT_13);

        if (substr($candidate, 12, 2) != strval($firstDigit . $secondDigit)) {
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
