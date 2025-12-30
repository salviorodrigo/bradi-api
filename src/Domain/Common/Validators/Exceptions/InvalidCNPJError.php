<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidCNPJError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'this value must be a valid brazilian CNPJ value, with just numeric chars.';
    }
}

// TODO Make test file.
