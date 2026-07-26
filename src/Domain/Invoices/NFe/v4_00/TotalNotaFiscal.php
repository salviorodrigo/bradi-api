<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        326
 * ID       W01
 * Campo    total
 * Desc     Grupo de Tributos incidentes no Produto ou Servico
 * Tam      1-1
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;

final class TotalNotaFiscal extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'total';

    protected function tagElementsValidators(): array
    {
        return [];
    }
}
