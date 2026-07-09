<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\AmbienteEmissao;
use InvalidArgumentException;

final class IsAmbienteEmissaoValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) AmbienteEmissao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be tpAmb according MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}
