<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        164
 * ID       N01
 * Campo    ICMS
 * Desc     Grupo de Tributacao do ICMS
 * Tam      1-1
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;

final class Icms extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'ICMS';

    public Icms00 $ICMS00;

    protected function tagElementsValidators(): array
    {
        return [
            new AtLeastOneTagValidator(['ICMS00']),
        ];
    }
}
