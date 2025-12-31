<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidIndFinalError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be 1 to domestic or 0 case else.';
    }
}
