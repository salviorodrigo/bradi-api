<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
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
