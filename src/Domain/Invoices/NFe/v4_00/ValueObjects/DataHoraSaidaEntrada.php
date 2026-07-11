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

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

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
