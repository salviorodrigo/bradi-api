<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       YA1
 * Campo    pag
 * Desc     Grupo de informações de pagamento
 * Tam      1-1
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorTroco;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class InformacoesPagamento extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'pag';

    public DetalhamentoPagamentoCollection $detPag;
    public ?ValorTroco $vTroco;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['detPag']),
            new AllowedTagsValidator(['detPag', 'vTroco']),
        ];
    }
}
