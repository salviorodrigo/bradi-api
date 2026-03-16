<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\InvalidTypeError;

final class IsStringValidator extends Validator
{
    public function __construct(public readonly string $field, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        if (! is_string($candidate)) {
            return Result::makeFailure(new InvalidTypeError(
                $this->field,
                $this->source,
                $candidate,
                'string'
            ));
        }

        return Result::makeSuccess();
    }
}
