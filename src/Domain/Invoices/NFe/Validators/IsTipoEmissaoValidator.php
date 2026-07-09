<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoEmissaoNF;
use InvalidArgumentException;

final class IsTipoEmissaoValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) TipoEmissaoNF::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('it must be 1 to normal, 2 to contingency FS-IA, 3 to contingency SCAN, 4 to contingency EPEC, 5 to contingency FS-DA, 6 to contingency SVC-AN, 7 to contingency SVC-RS, or 9 to contingency off-line of NFC-e.'));
        }

        return Result::makeSuccess();
    }
}
