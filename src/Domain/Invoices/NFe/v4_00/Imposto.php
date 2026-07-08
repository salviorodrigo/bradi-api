<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        163
 * ID       M01
 * Campo    imposto
 * Desc     Grupo de Tributos incidentes no Produto ou Servico
 * Tam      1-1
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Imposto extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'imposto';

    public Icms $ICMS;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['ICMS']),
        ];
    }
}
