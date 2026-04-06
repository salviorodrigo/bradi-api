<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

class FakeValidator implements Validator
{
    public function __construct() {}

    public function check(mixed $candidate): Result
    {
        return $this->validate($candidate);
    }

    public function validate(mixed $candidate): Result
    {
        return Result::makeSuccess();
    }
}
