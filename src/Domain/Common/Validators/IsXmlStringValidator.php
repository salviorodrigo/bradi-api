<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsXmlStringValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        $typeValidationResponse = $this->validateType($candidate);
        if (! $typeValidationResponse->isSuccess()) {
            return $typeValidationResponse;
        }
        if (simplexml_load_string($candidate, options: LIBXML_NOERROR) === false) {
            return Result::makeFailure(new InvalidArgumentException('must be a valid XML string.'));
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        if (! is_string($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be a valid XML string.'));
        }

        return Result::makeSuccess();
    }
}
