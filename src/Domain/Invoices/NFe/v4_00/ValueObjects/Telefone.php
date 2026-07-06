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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class Telefone extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'fone';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new MaxStringLengthValidator(14),
            new MinStringLengthValidator(6),
        ];
    }
}
