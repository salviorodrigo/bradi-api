<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\InvalidUuidV7Error;
use UUID\UUID;

final class IsUuidV7Validator extends Validator
{
    public function __construct(public readonly string $field, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        if (UUID::isValid($candidate) && UUID::getVersion($candidate) == 7) {
            return Result::makeSuccess();
        }

        return Result::makeFailure(new InvalidUuidV7Error(
            $this->field,
            $this->source,
            $candidate
        ));
    }
}
