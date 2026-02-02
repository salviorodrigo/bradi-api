<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions\InvalidCodigoMercosulError;

final class IsCodigoMercosulValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (is_numeric($candidate) && strlen(strval($candidate)) === 8) && $candidate !== '00') {
            return Result::makeFailure(
                new InvalidCodigoMercosulError($this->fieldName)
            );
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
