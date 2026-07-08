<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       BA13, C02, E02, F02, G02, GA02, X4
 * Campo    CNPJ
 * Desc     Cadastro nacional de Pessoa Juridica
 * Tam      14
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsCNPJValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CadastroPJ extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'CNPJ';

    protected function tagValueValidators(): array
    {
        return [
            new IsCNPJValidator,
        ];
    }
}
