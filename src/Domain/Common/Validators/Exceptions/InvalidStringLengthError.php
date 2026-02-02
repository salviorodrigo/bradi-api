<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidStringLengthError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly array $stringLength)
    {
        $this->message = 'chars quantity should be ' . json_encode($this->stringLength) . '.';
    }
}
