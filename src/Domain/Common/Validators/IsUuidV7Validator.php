<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotUuidV7Error;
use UUID\UUID;

final class IsUuidV7Validator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (UUID::isValid($candidate) && UUID::getVersion($candidate) == 7) {
            return Result::makeSuccess();
        }

        return Result::makeFailure(new IsNotUuidV7Error($this->fieldName));
    }
}
