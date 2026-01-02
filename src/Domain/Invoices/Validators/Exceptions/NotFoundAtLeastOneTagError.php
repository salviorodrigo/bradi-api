<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class NotFoundAtLeastOneTagError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, public readonly array $tags)
    {
        $this->message = 'at least one tag of (' . implode(', ', $tags) . ') is required.';
    }
}
