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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

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
