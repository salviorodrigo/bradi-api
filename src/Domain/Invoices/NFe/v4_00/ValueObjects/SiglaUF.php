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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiApi\Domain\Invoices\Validators\IsSiglaUnidadeFederativaValidator;

final class SiglaUF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'UF';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(2),
            new IsSiglaUnidadeFederativaValidator,
        ];
    }
}
