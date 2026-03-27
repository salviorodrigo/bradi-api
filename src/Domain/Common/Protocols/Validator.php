<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Domain\Common\ValueObjects\Result;

abstract class Validator
{
    public readonly string $fieldURI;
    public readonly string $source;

    abstract public function validate(mixed $candidate): Result;
}
