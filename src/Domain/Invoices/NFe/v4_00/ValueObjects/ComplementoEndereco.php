<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        37, 69, 84, 93
 * ID       C08, E08, F05, G05
 * Campo    xCpl
 * Desc     Complemento do endereco
 * Tam      1-60
 * OBS:
 * Tag opcional.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ComplementoEndereco extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xCpl';

    protected function tagValueValidators(): array
    {
        return [
            new MinStringLengthValidator(1),
            new MaxStringLengthValidator(60),
            new TextFormatValidator,
        ];

    }
}
