<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        98
 * ID       H01
 * Campo    det
 * Desc     Detalhamento de Produtos e Serviços
 * Tam      1-990
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class DetalhamentoItem extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'det';

    public NumeroItem $nItem;
    public Produto $prod;
    public Imposto $imposto;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['prod', 'imposto']),
        ];
    }

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [
            new RequiredAttributeValidator(['nItem']),
        ];
    }
}
