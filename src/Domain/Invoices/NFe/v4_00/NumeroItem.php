<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        98
 * ID       H01
 * Campo    nItem
 * Desc     Número do Item
 * Tam      1-3
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeAttribute;

final class NumeroItem extends DFeAttribute
{
    public const string FIELD_NAME = 'nItem';

    protected function attributeValueValidators(): array
    {
        return [
            new IsNumericValidator(),
            new MinValueValidator(1),
            new MaxValueValidator(990)
        ];
    }
}
