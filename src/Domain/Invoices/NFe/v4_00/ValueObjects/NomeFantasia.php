<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C034
 * Campo    xFant
 * Desc     Nome Fantasia
 * Tam      2-60
 * OBS:
 * Tag opcional.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NomeFantasia extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xFant';

    protected function tagValueValidators(): array
    {
        return [
            new MinStringLengthValidator(2),
            new MaxStringLengthValidator(60),
            new TextFormatValidator,
        ];
    }
}
