<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        15
 * ID       B11
 * Campo    tpNF
 * Desc     Tipo de Operação
 * Tam      1
 * OBS:
 * 0=Entrada;
 * 1=Saída
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoMovimentacaoValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class TipoNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'tpNF';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoMovimentacaoValidator,
        ];
    }
}
