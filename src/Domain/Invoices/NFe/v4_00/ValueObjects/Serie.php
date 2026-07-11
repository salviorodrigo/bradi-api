<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B07
 * Campo    serie
 * Desc     Série do Documento Fiscal
 * Tam      1-3
 * OBS:
 * Série do Documento Fiscal, preencher com zeros na hipótese
 * de a NF-e não possuir série. Série na faixa:
 * - [000-889]: Aplicativo do Contribuinte; Emitente=CNPJ; Assinatura
 * pelo e-CNPJ do contribuinte (procEmi<>1,2);
 *
 * - [890-899]: Emissão no site do Fisco (NFA-e - Avulsa);
 * Emitente= CNPJ / CPF; Assinatura pelo e-CNPJ da SEFAZ (procEmi=1);
 *
 * - [900-909]: Emissão no site do Fisco (NFA-e); Emitente= CNPJ; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CNPJ do
 * contribuinte (procEmi=2);
 *
 * - [910-919]: Emissão no site do Fisco (NFA-e); Emitente= CPF; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CPF do
 * contribuinte (procEmi=2);
 *
 * - [920-969]: Aplicativo do Contribuinte; Emitente=CPF; Assinatura pelo
 *  e-CPF do contribuinte (procEmi<>1,2);
 * (Atualizado NT 2018/001)
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class Serie extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'serie';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new MaxStringLengthValidator(3),
            new MinValueValidator(0),
            new MaxValueValidator(969),
        ];
    }
}
