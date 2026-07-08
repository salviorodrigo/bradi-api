<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       BA14, C02a, E03, F02a, G02a, GA03, X5
 * Campo    CPF
 * Desc     Cadastro nacional de Pessoa Física
 * Tam      11
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsCPFValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CadastroPF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'CPF';

    protected function tagValueValidators(): array
    {
        return [
            new IsCPFValidator,
        ];
    }
}
