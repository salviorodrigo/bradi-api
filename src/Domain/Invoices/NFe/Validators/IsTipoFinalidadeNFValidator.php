<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoFinalidadeNF;
use InvalidArgumentException;

final class IsTipoFinalidadeNFValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoFinalidadeNF::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('it must be 1 to domestic or 0 case else.'));
        }

        return Result::makeSuccess();
    }
}
