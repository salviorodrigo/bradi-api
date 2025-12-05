<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidCodigoNFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be an integer random number with 8 chars and greater than zero.';
    }
}
