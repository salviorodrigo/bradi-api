<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoModalidadeBC;
use InvalidArgumentException;

final class IsTipoModalidadeBCValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoModalidadeBC::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be 0, 1, 2 or 3 according modBC of MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
