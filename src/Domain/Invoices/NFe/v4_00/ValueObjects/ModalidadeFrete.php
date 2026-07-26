<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       X02
 * Campo    modFrete
 * Desc     Modalidade do frete
 * Tam      1
 * OBS:
 * 0=Contratação do Frete por conta do Remetente (CIF);
 * 1=Contratação do Frete por conta do Destinatário (FOB);
 * 2=Contratação do Frete por conta de Terceiros;
 * 3=Transporte Próprio por conta do Remetente;
 * 4=Transporte Próprio por conta do Destinatário;
 * 9=Sem Ocorrência de Transporte.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsModalidadeFreteValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ModalidadeFrete extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'modFrete';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new StringLengthValidator(1),
            new IsModalidadeFreteValidator,
        ];
    }
}
