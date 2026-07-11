<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        104d
 * ID       I05c
 * Campo    CEST
 * Desc     Código CEST (Código Especificador da Substituição Tributária) com 7 dígitos
 * Tam      2-8
 * OBS:
 * Campo CEST (Código Especificador da Substituição Tributária), que
 * estabelece a sistemática de uniformização e identificação das
 * mercadorias e bens passíveis de sujeição aos regimes de substituição
 * tributária e de antecipação de recolhimento do ICMS.
 * (Incluído na NT 2015/003. Atualizado NT2016.002)
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoSubstituicaoTributaria extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'CEST';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(stringLength: 7),
            new IsNumericValidator(allowLeadingZeros: true),
        ];
    }
}
