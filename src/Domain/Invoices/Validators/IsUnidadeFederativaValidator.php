<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use BradiNfeApi\Domain\Invoices\Validators\Exceptions\InvalidCodigoUFError;

final class IsUnidadeFederativaValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) UnidadeFederativa::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidCodigoUFError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
