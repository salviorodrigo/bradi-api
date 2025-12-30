<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class TooShortStringError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly int $stringLength)
    {
        $this->message = 'string length should be greater than ' . $this->stringLength . '.';
    }
}
