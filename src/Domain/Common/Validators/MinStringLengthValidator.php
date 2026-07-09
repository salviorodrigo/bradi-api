<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use LengthException;

final class MinStringLengthValidator implements Validator
{
    public function __construct(
        public readonly int $minStringLength
    ) {}

    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator;
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure() || strlen($candidate) < $this->minStringLength) {
            return Result::makeFailure(new LengthException(sprintf(
                'must contain at least %d characters.',
                $this->minStringLength
            )));
        }

        return Result::makeSuccess();
    }
}
