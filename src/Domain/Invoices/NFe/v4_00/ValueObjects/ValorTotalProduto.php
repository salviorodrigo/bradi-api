<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        110
 * ID       I11
 * Campo    vProd
 * Desc     Valor Total Bruto dos Produtos ou Serviços
 * Tam      13v2
 * OBS:
 * 13v2
 * O valor do ICMS faz parte do Valor Total Bruto
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ValorTotalProduto extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'vProd';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(13, 2),
            new MaxValueValidator(9999999999999.99),
            new MinValueValidator(0.01),
        ];
    }
}
