<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoMovimentacao;
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
