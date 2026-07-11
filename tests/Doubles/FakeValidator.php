<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;

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
