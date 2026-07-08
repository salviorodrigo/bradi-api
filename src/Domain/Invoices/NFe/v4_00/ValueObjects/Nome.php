<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C03, E04, F02a, G02b, x06
 * Campo    xNome
 * Desc     Razao Social ou nome da entidade
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

final class Nome extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xNome';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(2),
            new TextFormatValidator,
        ];
    }
}
