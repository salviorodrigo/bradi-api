<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       Q08
 * Campo    pPIS
 * Desc     Aliquota do PIS (em percentual)
 * Tam      3v2-4
 * OBS:
 * Percentual da aliquota do PIS.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsDecimalValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class AliquotaPIS extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'pPIS';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(maxIntegerDigits: 3, maxDecimalDigits: 4, minDecimalDigits: 2),
            new MaxValueValidator(100),
            new MinValueValidator(0),
        ];
    }
}
