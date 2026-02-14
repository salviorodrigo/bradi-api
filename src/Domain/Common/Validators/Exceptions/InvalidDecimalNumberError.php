<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidDecimalNumberError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly int $maxIntegerDigits, public readonly int $maxDecimalDigits)
    {
        $this->message = "should be a decimal number with up to {$this->maxIntegerDigits} integer digits and {$this->maxDecimalDigits} decimal digits, separated by dot.";
    }
}
