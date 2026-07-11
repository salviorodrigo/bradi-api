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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiApi\Domain\Invoices\Validators\IsAmbienteEmissaoValidator;

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
