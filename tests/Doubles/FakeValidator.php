<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

class FakeValidator extends Validator
{
    public function __construct(public readonly string $fieldURI) {}

    public function validate(mixed $candidate): Result
    {
        return Result::makeSuccess();
    }
}
