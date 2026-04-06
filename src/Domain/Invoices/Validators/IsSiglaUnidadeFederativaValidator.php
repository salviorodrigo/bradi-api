<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use InvalidArgumentException;

final class IsSiglaUnidadeFederativaValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! in_array($candidate, array_column(UnidadeFederativa::cases(), 'name'))) {
            return Result::makeFailure(new InvalidArgumentException('must be a valid UF according MOC NFe e NFCe (7.0) - Anexo I..'));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
