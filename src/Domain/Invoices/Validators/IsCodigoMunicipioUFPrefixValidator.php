<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\UnidadeFederativa;
use InvalidArgumentException;

final class IsCodigoMunicipioUFPrefixValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if ($candidate === '' || $candidate === '9999999') {
            return Result::makeSuccess();
        }

        $ufCode = substr($candidate, 0, 2);

        if (! (bool) UnidadeFederativa::tryFrom($ufCode)) {
            return Result::makeFailure(new InvalidArgumentException('city code prefix must be a valid cUF according MOC NFe e NFCe (7.0) - Anexo I.'));
        }

        return Result::makeSuccess();
    }
}
