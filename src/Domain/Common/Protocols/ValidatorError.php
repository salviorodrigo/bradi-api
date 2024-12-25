<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use Exception;

abstract class ValidatorError extends Exception
{
    public readonly string $fieldName;
}
