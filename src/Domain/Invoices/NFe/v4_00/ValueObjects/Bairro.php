<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C08, E08, F05
 * Campo    xBairro
 * Desc     Bairro
 * Tam      2-60
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class Bairro extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xBairro';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new TextFormatValidator,
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(2),
        ];
    }
}
