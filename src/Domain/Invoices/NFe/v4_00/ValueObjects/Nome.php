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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

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
