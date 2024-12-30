<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;

final class FakeValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        return Result::makeSuccess();
    }
}
