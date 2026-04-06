<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoMovimentacao;
use InvalidArgumentException;

final class IsTipoMovimentacaoValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoMovimentacao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('it must be 0 to entry or 1 to outlet.'));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
