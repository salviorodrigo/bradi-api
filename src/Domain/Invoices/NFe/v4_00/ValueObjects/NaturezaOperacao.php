<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B04
 * Campo    natOp
 * Desc     Descrição da Natureza da Operação
 * Tam      1-60
 * OBS:
 * Informar a natureza da operação de que decorrer a saída
 * ou a entrada, tais como: venda, compra, transferência,
 * devolução, importação, consignação, remessa (para fins de
 * demonstração, de industrialização ou outra), conforme previsto
 * na alínea 'i', inciso I, art. 19 do CONVENIO S/Nº, de 15 de
 * dezembro de 1970.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NaturezaOperacao extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'natOp';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(60),
            new TextFormatValidator,
        ];
    }
}
