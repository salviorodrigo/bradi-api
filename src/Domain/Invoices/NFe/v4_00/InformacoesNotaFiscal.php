<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        17
 * ID       A01
 * Campo    infNFe
 * Desc     Informacoes da NF-e
 * Tam
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\VersaoDocumentoFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Validators\HasNoTextContentValidator;
use BradiApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class InformacoesNotaFiscal extends DFeElement
{
    public const string FIELD_NAME = 'infNFe';

    public VersaoDocumentoFiscal $versao;
    public IdentificacaoNF $ide;
    public Emitente $emit;
    public ?Destinatario $dest;
    public DetalhamentoItem $det;

    /** @return array<Validator> */
    protected function tagValueValidators(): array
    {
        return [new HasNoTextContentValidator];
    }

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [
            new RequiredAttributeValidator(['Id', 'versao']),
        ];
    }

    /** @return array<Validator> */
    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['ide', 'emit']),
        ];
    }
}
