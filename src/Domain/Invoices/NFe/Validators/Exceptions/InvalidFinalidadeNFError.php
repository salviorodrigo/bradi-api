<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidFinalidadeNFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be 1 to normal, 2 to complement, 3 to adjust or 4 to return.';
    }
}
