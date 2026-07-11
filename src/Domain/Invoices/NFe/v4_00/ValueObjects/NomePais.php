<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        44
 * ID       C15
 * Campo    xPais
 * Desc     Nome Pais
 * Tam      1-60
 * OBS:
 * Tag opcional.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NomePais extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xPais';

    protected function tagValueValidators(): array
    {
        return [
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(2),
            new TextFormatValidator,
        ];

    }
}
