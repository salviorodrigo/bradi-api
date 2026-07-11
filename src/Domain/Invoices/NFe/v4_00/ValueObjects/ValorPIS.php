<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       Q09
 * Campo    vPIS
 * Desc     Valor do PIS
 * Tam      13v2
 * OBS:
 * Valor do PIS da operacao.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsDecimalValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ValorPIS extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'vPIS';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(13, 2),
            new MaxValueValidator(9999999999999.99),
            new MinValueValidator(0),
        ];
    }
}
