<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class InvalidTipoEmissaoNFError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'it must be 1 to normal, 2 to contingency FS-IA, 3 to contingency SCAN, 4 to contingency EPEC, 5 to contingency FS-DA, 6 to contingency SVC-AN, 7 to contingency SVC-RS, or 9 to contingency off-line of NFC-e.';
    }
}
