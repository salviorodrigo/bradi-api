<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       S08
 * Campo    pCOFINS
 * Desc     Aliquota da COFINS (em percentual)
 * Tam      3v2-4
 * OBS:
 * Percentual da aliquota da COFINS.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class AliquotaCOFINS extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'pCOFINS';

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
