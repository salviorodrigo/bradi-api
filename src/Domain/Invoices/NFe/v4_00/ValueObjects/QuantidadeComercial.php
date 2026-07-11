<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I10
 * Campo    qCom
 * Desc     Quantidade Comercial
 * Tam      11v0-4
 * OBS:
 * Informar a quantidade de comercialização do produto (v2.0).
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsDecimalValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class QuantidadeComercial extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'qCom';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(11, 4),
            new MaxValueValidator(99999999999.9999),
            new MinValueValidator(0.0001),
        ];
    }
}
