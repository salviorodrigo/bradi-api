<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class RequiredParamValidator implements Validator
{
    public function check(mixed $candidate): Result
    {

        if ($this->{'isEmpty' . ucfirst(gettype($candidate))}($candidate) || is_null($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('required param.'));
        }

        return Result::makeSuccess();
    }

    private function isEmptyString(string $candidate): bool
    {
        $candidate = trim($candidate);

        return $candidate === '' || $candidate === 'null';
    }

    private function isEmptyArray(array $candidate): bool
    {
        return is_array($candidate) && count($candidate) === 0;
    }

    private function isEmptyObject(object $candidate): bool
    {
        return is_object($candidate) && count(get_object_vars($candidate)) === 0;
    }
}

/**
 * "boolean"
 * "integer"
 * "double" (for historical reasons "double" is returned in case of a float, and not simply "float")
 * "string"
 * "array"
 * "object"
 * "resource"
 * "resource (closed)" as of PHP 7.2.0
 * "NULL"
 * "unknown type"
**/

// TODO Make test file.
