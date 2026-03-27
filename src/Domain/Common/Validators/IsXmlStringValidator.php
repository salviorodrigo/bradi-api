<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Exceptions\InvalidXmlStringError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;

final class IsXmlStringValidator extends Validator
{
    public function __construct(public readonly string $fieldURI, public readonly string $source) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidationResponse = $this->validateType($candidate);
        if (! $typeValidationResponse->isSuccess()) {
            return $typeValidationResponse;
        }
        if (simplexml_load_string($candidate, options: LIBXML_NOERROR) === false) {
            return Result::makeFailure(new InvalidXmlStringError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }

    private function validateType(mixed $candidate): Result
    {
        if (! is_string($candidate)) {
            return Result::makeFailure(new InvalidXmlStringError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}
