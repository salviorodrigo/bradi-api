<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I04
 * Campo    xProd
 * Desc     Descricao Produto
 * Tam      1-120
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class DescricaoProduto extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'xProd';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(120),
            new TextFormatValidator,
        ];

    }
}
