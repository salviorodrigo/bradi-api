<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\FinalidadeEmissao;
use InvalidArgumentException;

final class IsFinalidadeEmissaoValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) FinalidadeEmissao::tryFrom($candidate)) {
            return Result::makeFailure(
                new InvalidArgumentException(
                    'it must be 1 to normal, 2 to complement, 3 to adjust or 4 to return.'
                ));
        }

        return Result::makeSuccess();
    }
}
