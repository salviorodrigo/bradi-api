<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C17
 * Campo    IE
 * Desc     Inscrição Estadual
 * Tam      2-14
 * OBS:
 * Informar somente os algarismos, sem os caracteres
 * de formatação (ponto, barra, hífen, etc.).
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class InscricaoEstadual extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'IE';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator(allowLeadingZeros: true),
            new MaxStringLengthValidator(maxStringLength: 14),
            new MinStringLengthValidator(minStringLength: 2),
        ];
    }
}
