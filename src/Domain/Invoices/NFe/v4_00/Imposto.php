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

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

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
