<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B03
 * Campo    cNF
 * Desc     Código Numérico que compõe a Chave de Acesso
 * Tam      8
 * OBS:
 * Código numérico que compõe a Chave de Acesso. Número aleatório
 * gerado pelo emitente para cada NF-e para evitar acessos
 * indevidos da NF-e. (v2.0)
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Invoices\NFe\Validators\IsCodigoNFValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'cNF';

    protected function tagValueValidators(): array
    {
        return [
            new IsCodigoNFValidator,
        ];
    }
}
