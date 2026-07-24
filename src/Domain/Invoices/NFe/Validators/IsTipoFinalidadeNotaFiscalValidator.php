<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoFinalidadeNotaFiscal;
use InvalidArgumentException;

final class IsTipoFinalidadeNotaFiscalValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoFinalidadeNotaFiscal::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('it must be 1 to domestic or 0 case else.'));
        }

        return Result::makeSuccess();
    }
}
