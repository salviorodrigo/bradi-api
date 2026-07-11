<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C16
 * Campo    fone
 * Desc     Telefone
 * Tam      6-14
 * OBS:
 * Tag opcional.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class Telefone extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'fone';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new MaxStringLengthValidator(14),
            new MinStringLengthValidator(6),
        ];
    }
}
