<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidTipoAmbienteError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be 1 to production or 2 to testing.';
    }
}
