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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

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
