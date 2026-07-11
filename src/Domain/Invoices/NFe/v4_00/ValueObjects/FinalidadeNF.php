<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B25
 * Campo    finNFe
 * Desc     Finalidade de emissão da NF-e
 * Tam      1
 * OBS:
 * 1=NF-e normal;
 * 2=NF-e complementar;
 * 3=NF-e de ajuste;
 * 4=Devolução de mercadoria.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsFinalidadeEmissaoValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class FinalidadeNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'finNFe';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(1),
            new IsFinalidadeEmissaoValidator,
        ];
    }
}
