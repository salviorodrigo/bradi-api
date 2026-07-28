<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       YA01a
 * Campo    detPag
 * Desc     Detalhamento do Pagamento
 * Tam      1-100
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\FormaPagamento;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;

final class DetalhamentoPagamento extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'detPag';

    public ?FormaPagamento $indPag;

    protected function tagElementsValidators(): array
    {
        return [];
    }
}
