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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NaturezaOperacao extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'natOp';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(60),
            new TextFormatValidator,
        ];
    }
}
