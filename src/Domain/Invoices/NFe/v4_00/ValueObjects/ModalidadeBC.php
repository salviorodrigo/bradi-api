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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoModalidadeBCValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ModalidadeBC extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'modBC';

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
