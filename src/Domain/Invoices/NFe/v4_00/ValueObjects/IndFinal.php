<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B25a
 * Campo    indFinal
 * Desc     Indica operação com Consumidor final
 * Tam      1
 * OBS:
 * 0=Normal;
 * 1=Consumidor final;
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoFinalidadeNFValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class IndFinal extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'indFinal';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoFinalidadeNFValidator,
        ];
    }
}
