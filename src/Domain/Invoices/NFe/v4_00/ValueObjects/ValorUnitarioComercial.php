<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        108
 * ID       I09
 * Campo    vUnCom
 * Desc     Valor Unitário de Comercialização
 * Tam      1-6
 * OBS:
 * Informar o valor unitário de comercialização do produto, campo
 * meramente informativo, o contribuinte pode utilizar a precisão
 * desejada (0-10 decimais). Para efeitos de cálculo, o valor unitário
 * será obtido pela divisão do valor do produto pela quantidade
 * comercial. (v2.0)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ValorUnitarioComercial extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'vUnCom';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(11, 10),
            new MaxValueValidator(99999999999.9999999999),
            new MinValueValidator(0.0000000001),
        ];
    }
}
