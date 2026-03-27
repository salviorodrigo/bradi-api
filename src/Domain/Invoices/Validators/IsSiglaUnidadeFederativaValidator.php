<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use BradiNfeApi\Domain\Invoices\Exceptions\InvalidSiglaUFError;

final class IsSiglaUnidadeFederativaValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! in_array($candidate, array_column(UnidadeFederativa::cases(), 'name'))) {
            return Result::makeFailure(new InvalidSiglaUFError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
