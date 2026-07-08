<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I03
 * Campo    cEAN
 * Desc     GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de barras
 * Tam      0, 8, 12, 13 ou 14
 * OBS:
 * Preencher com o código GTIN-8, GTIN-12, GTIN-13 ou
 * GTIN-14 (antigos códigos EAN, UPC e DUN-14);
 * Para produtos que não possuem código de barras com
 * GTIN, deve ser informado o literal “SEM GTIN”; (atualizado NT 2017/001)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsValidCodigoBarrasValidator;

final class CodigoBarras extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'cEAN';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new TextFormatValidator,
            new StringLengthValidator(8, 12, 13, 14),
            new IsValidCodigoBarrasValidator,
        ];
    }
}
