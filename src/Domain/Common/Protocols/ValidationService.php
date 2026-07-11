<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Protocols;

use BradiApi\Domain\Common\ValueObjects\Result;

interface ValidationService
{
    public function addValidator(Validator $validator): ValidationService;

    public function verify(mixed $candidate): Result;

    public function reset(): void;
}
