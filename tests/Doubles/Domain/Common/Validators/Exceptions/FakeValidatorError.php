<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Common\Validators\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class FakeValidatorError extends ValidatorError
{
    public function __construct(public readonly string $fieldName, string $message)
    {
        parent::__construct($message);
    }
}
