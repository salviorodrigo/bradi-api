<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;
use UUID\UUID;

final class IsUuidV7Validator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (UUID::isValid($candidate) && UUID::getVersion($candidate) == 7) {
            return Result::makeSuccess();
        }

        return Result::makeFailure(new InvalidArgumentException('must be a valid UUID v7.'));
    }
}
