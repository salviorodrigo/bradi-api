<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Common;

use BradiNfeApi\Domain\Common\Protocols\ValidationService;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class FakeValidationService implements ValidationService
{
    public function addValidator(Validator $validator): ValidationService
    {
        return $this;
    }

    public function verify(mixed $candidate): Result
    {
        return Result::makeSuccess(null);
    }

    public function reset(): void {}
}
