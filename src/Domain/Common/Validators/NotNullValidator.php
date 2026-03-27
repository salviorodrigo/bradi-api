<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\IsNullError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class NotNullValidator extends Validator
{
    public function __construct(public readonly string $fieldURI, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        if (is_null($candidate) || $this->{'isEmpty' . ucfirst(gettype($candidate))}($candidate)) {
            return Result::makeFailure(new IsNullError(
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

        return $candidate == '' || $candidate == 'null';
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

// TODO Make test file.
