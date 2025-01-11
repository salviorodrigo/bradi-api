<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class IsNullError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'cannot be null.';
    }
}
