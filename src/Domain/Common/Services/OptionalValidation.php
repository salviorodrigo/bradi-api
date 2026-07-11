<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Services;

use BradiApi\Domain\Common\Protocols\ValidationService;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;

final class OptionalValidation implements ValidationService
{
    public function __construct(
        private readonly ValidationService $validationService
    ) {}

    public function addValidator(Validator $validator): ValidationService
    {
        $this->validationService->addValidator($validator);

        return $this;
    }

    public function verify(mixed $candidate): Result
    {
        if ($candidate === null) {
            return Result::makeSuccess();
        }

        if (is_string($candidate) && trim($candidate) === '') {
            return Result::makeSuccess();
        }

        if (is_array($candidate) && $candidate === []) {
            return Result::makeSuccess();
        }

        return $this->validationService->verify($candidate);
    }

    public function reset(): void
    {
        $this->validationService->reset();
    }
}
