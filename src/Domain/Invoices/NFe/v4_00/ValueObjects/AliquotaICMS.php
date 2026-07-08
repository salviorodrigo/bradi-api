<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N16
 * Campo    pICMS
 * Desc     Aliquota do imposto
 * Tam      3v2-4
 * OBS:
 * Percentual da aliquota do ICMS.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class AliquotaICMS extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'pICMS';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(3, 4),
            new MaxValueValidator(100),
            new MinValueValidator(0),
        ];
    }
}
