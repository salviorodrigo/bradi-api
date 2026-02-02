<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidCodigoMercosulError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be 00 or a numeric value with 8 digits.';
    }
}
