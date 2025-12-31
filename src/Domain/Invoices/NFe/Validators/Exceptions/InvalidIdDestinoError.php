<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidIdDestinoError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it should be 0 to domestic, 1 to interstate or 2 to exportation.';
    }
}
