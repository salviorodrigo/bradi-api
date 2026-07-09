<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\FinalidadeEmissao;
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
