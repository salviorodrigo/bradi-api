<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N13
 * Campo    modBC
 * Desc     Modalidade de determinação da BC do ICMS
 * Tam      1
 * OBS:
 * 0=Margem Valor Agregado (%);
 * 1=Pauta (Valor);
 * 2=Preço Tabelado Máx. (valor);
 * 3=Valor da operação.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoModalidadeBCValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ModalidadeBC extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'modBC';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoModalidadeBCValidator,
        ];
    }
}
