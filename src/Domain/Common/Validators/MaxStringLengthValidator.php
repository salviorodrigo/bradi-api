<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use LengthException;

final class MaxStringLengthValidator implements Validator
{
    public function __construct(
        public readonly int $maxStringLength
    ) {}

    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator;
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure() || strlen($candidate) > $this->maxStringLength) {
            return Result::makeFailure(new LengthException(sprintf(
                'cannot contain more than %d characters.',
                $this->maxStringLength
            )));
        }

        return Result::makeSuccess();
    }
}
