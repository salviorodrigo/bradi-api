<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoSituacaoTributaria;
use InvalidArgumentException;

final class IsTipoSituacaoTributariaValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoSituacaoTributaria::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be a valid CST according MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
