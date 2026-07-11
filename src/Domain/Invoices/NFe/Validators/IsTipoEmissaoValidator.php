<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Enums\TipoEmissaoNF;
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
