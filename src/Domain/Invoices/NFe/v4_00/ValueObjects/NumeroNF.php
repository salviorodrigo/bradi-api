<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B08
 * Campo    nNF
 * Desc     Número do Documento Fiscal
 * Tam      1-9
 * OBS:
 * Número do Documento Fiscal
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NumeroNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'nNF';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new MaxStringLengthValidator(9),
            new MinValueValidator(1),
        ];
    }
}
