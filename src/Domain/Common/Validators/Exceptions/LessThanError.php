<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class LessThanError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly float $minValue)
    {
        $this->message = 'this value must not be less than ' . $this->minValue . '.';
    }
}
