<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidTipoNFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must 0 to entry or 1 to outlet.';
    }
}
