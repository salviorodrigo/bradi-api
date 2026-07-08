<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I02
 * Campo    cProd
 * Desc     Código do produto ou serviço
 * Tam      1-60
 * OBS:
 * Preencher com CFOP, caso se trate de itens não relacionados
 * com mercadorias/produtos e que o contribuinte não possua
 * codificação própria.
 * Formato: ”CFOP9999”
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoProduto extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'cProd';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(1),
            new TextFormatValidator,
        ];
    }
}
