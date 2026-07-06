<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B12
 * Campo    cMunFG
 * Desc     Código do Município de Ocorrência do Fato Gerador
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioUFPrefixValidator;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioValidator;

final class CodigoMunicipioFatoGerador extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'cMunFG';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(7),
            new IsCodigoMunicipioValidator,
            new IsCodigoMunicipioUFPrefixValidator,
        ];
    }
}
