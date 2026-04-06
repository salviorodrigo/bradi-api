<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
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
