<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoOperacao;
use InvalidArgumentException;

final class IsTipoOperacaoValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoOperacao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('it should be 0 to intrastate, 1 to interstate or 2 to exportation.'));
        }

        return Result::makeSuccess();
    }
}
