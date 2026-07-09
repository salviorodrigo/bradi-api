<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class IsCodigoMercosulValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (is_numeric($candidate) && strlen(strval($candidate)) === 8) && $candidate !== '00') {
            return Result::makeFailure(new InvalidArgumentException(
                'must be "00" or an 8-digit numeric value.'
            ));
        }

        return Result::makeSuccess();
    }
}
