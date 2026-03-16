<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Protocols;

use BradiNfeApi\Common\ValueObjects\Result;

abstract class Validator
{
    public readonly string $fieldURI;
    public readonly string $source;

    abstract public function validate(mixed $candidate): Result;
}
