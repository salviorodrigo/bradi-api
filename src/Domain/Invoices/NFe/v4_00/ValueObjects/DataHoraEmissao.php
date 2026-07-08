<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B09
 * Campo    dhEmi
 * Desc     Data e hora de emissão do Documento Fiscal
 * Tam
 * OBS:
 * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

class DataHoraEmissao extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'dhEmi';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(25),
            new FormatDataHoraTZDValidator,
        ];
    }
}
