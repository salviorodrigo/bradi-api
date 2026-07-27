<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       X01
 * Campo    transp
 * Desc     Grupo de Tributos incidentes no Produto ou Servico
 * Tam      1-1
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeFrete;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class InformacoesTransporte extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'transp';

    public ModalidadeFrete $modFrete;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['modFrete']),
            new AllowedTagsValidator(['modFrete', 'transporta', 'retTransp', 'veicTransp', 'reboque', 'vol', 'lacres']),
        ];
    }
}
