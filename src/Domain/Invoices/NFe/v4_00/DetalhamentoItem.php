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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

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
