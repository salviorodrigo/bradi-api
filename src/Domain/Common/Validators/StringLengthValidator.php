<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\InvalidStringLengthError;
use InvalidArgumentException;

final class StringLengthValidator extends Validator
{
    public readonly array $stringLengths;

    public function __construct(public readonly string $fieldName, mixed ...$stringLength)
    {
        foreach ($stringLength as $item) {
            if (! is_int($item)) {
                throw new InvalidArgumentException('stringLength attribute must be integer');
            }
        }
        $this->stringLengths = $stringLength;
    }

    public function validate(mixed $candidate): Result
    {
        if (! is_string($candidate) || ! array_find($this->stringLengths, fn ($stringLength) => strlen($candidate) === $stringLength)) {
            return Result::makeFailure(new InvalidStringLengthError($this->fieldName, $this->stringLengths));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
