<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidSerieError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be between 0 and 969.';
    }
}
