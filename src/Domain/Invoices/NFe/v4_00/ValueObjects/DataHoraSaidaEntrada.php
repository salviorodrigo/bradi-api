<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        14
 * ID       B10
 * Campo    dhSaiEnt
 * Desc     Data e hora de Saída ou da Entrada da Mercadoria/Produto
 * Tam
 * OBS:
 * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD;
 * Não informar este campo para a NFC-e.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

final class DataHoraSaidaEntrada extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'dhSaiEnt';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(25),
            new FormatDataHoraTZDValidator,
        ];
    }
}
