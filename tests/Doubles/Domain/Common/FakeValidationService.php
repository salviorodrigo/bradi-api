<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Common;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\ValueObjects\Result;

final class FakeValidationService extends ValidationService
{
    public function addValidator(Validator $validator): self
    {
        return $this;
    }

    public function verify(mixed $candidate): Result
    {
        return Result::makeSuccess(null);
    }

    public function reset(): void {}
}
