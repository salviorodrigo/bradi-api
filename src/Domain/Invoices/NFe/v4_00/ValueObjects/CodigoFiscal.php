<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I08
 * Campo    CFOP
 * Desc     Código CFOP (Código Fiscal de Operações e Prestações)
 * Tam      4
 * OBS:
 * Utilizar Tabela de CFOP.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoFiscal extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'CFOP';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new NotNullValidator,
            new StringLengthValidator(4),
        ];
    }
}
