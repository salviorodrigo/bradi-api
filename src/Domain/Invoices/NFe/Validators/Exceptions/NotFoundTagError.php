<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class NotFoundTagError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'xml tag is not found.';
    }
}
