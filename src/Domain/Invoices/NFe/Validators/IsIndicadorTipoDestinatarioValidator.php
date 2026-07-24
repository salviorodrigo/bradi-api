<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\IndicadorTipoDestinatario;
use InvalidArgumentException;

final class IsIndicadorTipoDestinatarioValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) IndicadorTipoDestinatario::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be 1, 2 or 9 according field indIEDest of MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}
