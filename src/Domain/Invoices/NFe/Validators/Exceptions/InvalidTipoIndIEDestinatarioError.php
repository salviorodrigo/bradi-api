<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidTipoIndIEDestinatarioError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it should be 1, 2 or 9 according MOC 7.0, field indIEDest.';
    }
}
