<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Validators;

use BradiNfeApi\Common\Exceptions\MissingParamError;
use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;

final class RequiredParamValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (is_null($candidate)) {
            return Result::makeFailure(new MissingParamError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        if ($this->{'isEmpty' . ucfirst(gettype($candidate))}($candidate)) {
            return Result::makeFailure(new MissingParamError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
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
