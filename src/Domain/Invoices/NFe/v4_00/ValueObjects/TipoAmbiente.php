<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        28
 * ID       B24
 * Campo    tpAmb
 * Desc     Identificação do Ambiente
 * Tam      1
 * OBS:
 * 1=Produção;
 * 2=Homologação.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsAmbienteEmissaoValidator;

final class TipoAmbiente extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'tpAmb';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(1),
            new IsAmbienteEmissaoValidator,
        ];
    }
}
