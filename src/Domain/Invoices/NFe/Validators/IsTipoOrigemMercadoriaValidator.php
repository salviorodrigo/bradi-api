<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoOrigemMercadoria;
use InvalidArgumentException;

final class IsTipoOrigemMercadoriaValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoOrigemMercadoria::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be one of 0, 1, 2, 3, 4, 5, 6, 7 or 8 according orig of MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}
