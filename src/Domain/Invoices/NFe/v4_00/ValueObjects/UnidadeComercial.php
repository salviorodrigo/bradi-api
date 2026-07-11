<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        109
 * ID       I10a
 * Campo    uCom
 * Desc     Unidade Comercial
 * Tam      1-6
 * OBS:
 * Informar a unidade de comercialização do produto.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class UnidadeComercial extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'uCom';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(6),
            new TextFormatValidator,
        ];
    }
}
