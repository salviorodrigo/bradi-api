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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsCodigoMercosulValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoMercosul extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'NCM';

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
