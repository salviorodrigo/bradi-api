<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        44
 * ID       C15
 * Campo    cPais
 * Desc     Código país
 * Tam      4
 * OBS:
 * 1058=Brasil/BRASIL
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoPais extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'cPais';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new StringLengthValidator(4),
        ];
    }
}
