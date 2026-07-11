<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B06
 * Campo    mod
 * Desc     Código do Modelo do Documento Fiscal
 * Tam      2
 * OBS:
 * 55=NF-e emitida em substituição ao modelo 1 ou 1A;
 * 65=NFC-e, utilizada nas operações de venda no
 * varejo (a critério da UF aceitar este modelo de documento).
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiApi\Domain\Invoices\Validators\IsModeloDFeValidator;

final class ModeloDFe extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'mod';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(2),
            new IsModeloDFeValidator,
        ];
    }
}
