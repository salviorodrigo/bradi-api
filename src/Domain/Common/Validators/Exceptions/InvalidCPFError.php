<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidCPFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'this value must be a valid brazilian CPF value, with just numeric chars.';
    }
}

// TODO Make test file.
