<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I02
 * Campo    NCM
 * Desc     Código NCM (Nomenclatura Comum Mercosul) com 8 dígitos
 * Tam      2-8
 * OBS:
 * Obrigatória informação do NCM completo (8 dígitos).
 * Nota: Em caso de item de serviço ou item que não tenham
 * produto (ex. transferência de crédito, crédito do ativo
 * imobilizado, etc.), informar o valor 00 (dois zeros).
 * (NT 2014/004)
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsCodigoMercosulValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoMercosul extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'NCM';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(min: 2, max: 8),
            new IsNumericValidator(allowLeadingZeros: true),
            new IsCodigoMercosulValidator,
        ];
    }
}
