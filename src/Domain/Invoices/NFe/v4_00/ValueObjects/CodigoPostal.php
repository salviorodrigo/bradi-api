<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        42
 * ID       C13
 * Campo    CEP
 * Desc     Código postal
 * Tam      8
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoPostal extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'CEP';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(allowLeadingZeros: true),
            new StringLengthValidator(stringLength: 8),
        ];
    }
}
