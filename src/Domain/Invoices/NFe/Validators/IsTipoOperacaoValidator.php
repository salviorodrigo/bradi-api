<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoOperacao;
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
