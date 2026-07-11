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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoPostal extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'CEP';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(allowLeadingZeros: true),
            new StringLengthValidator(stringLength: 8),
        ];
    }
}
