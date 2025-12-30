<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidSiglaUFError;

final class IsSiglaUnidadeFederativaValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! in_array($candidate, array_column(UnidadeFederativa::cases(), 'name'))) {
            return Result::makeFailure(new InvalidSiglaUFError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
