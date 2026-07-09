<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoIndIEDestinatario;
use InvalidArgumentException;

final class IsTipoIndIEDestinatarioValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoIndIEDestinatario::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be 1, 2 or 9 according field indIEDest of MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}
