<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidCodigoUFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be present in the IBGE table of federative unit codes - Section 8.1.';
    }
}
