<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C12
 * Campo    UF
 * Desc     Sigla da UF do emitente do Documento Fiscal
 * Tam      2
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsSiglaUnidadeFederativaValidator;

final class SiglaUF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'UF';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(2),
            new IsSiglaUnidadeFederativaValidator,
        ];
    }
}
