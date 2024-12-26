<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use Exception;
use Throwable;

abstract class ValidatorError extends Exception
{
    public readonly string $fieldName;

    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
