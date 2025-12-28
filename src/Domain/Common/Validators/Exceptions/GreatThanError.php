<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class GreatThanError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly float $maxValue)
    {
        $this->message = 'this value must not be great than ' . $this->maxValue . '.';
    }
}

// TODO Make test file.
