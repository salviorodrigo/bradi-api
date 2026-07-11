<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoSituacaoTributaria;
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
