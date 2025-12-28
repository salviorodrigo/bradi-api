<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class TooLongStringError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly int $stringLength)
    {
        $this->message = 'string length should not be up to great than ' . $this->stringLength . '.';
    }
}
