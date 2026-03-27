<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Exceptions\InvalidDateTimeFormatError;

final class FormatDataHoraTZDValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator($this->fieldURI, $this->source);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure()
            || ! preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])T([01]\d|2[0-3]):[0-5]\d:[0-5]\d([+-]\d{2}:\d{2})$/', $candidate)) {
            return Result::makeFailure(
                new InvalidDateTimeFormatError(
                    $this->fieldURI,
                    $this->source,
                    $candidate
                ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
