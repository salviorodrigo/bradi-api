<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Common\Result;

abstract class Validator
{
    public readonly string $fieldName;

    abstract public function validate(mixed $candidate): Result;
}
