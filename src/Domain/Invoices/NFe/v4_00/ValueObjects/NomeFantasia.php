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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

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
