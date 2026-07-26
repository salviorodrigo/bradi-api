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
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class TotalNotaFiscal extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'total';

    public IcmsTotalNotaFiscal $ICMSTot;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['ICMSTot']),
            new AllowedTagsValidator(['ICMSTot', 'ISSQNtot', 'retTrib']),
        ];
    }
}
