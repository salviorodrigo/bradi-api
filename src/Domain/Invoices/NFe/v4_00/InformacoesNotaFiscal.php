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
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedAttributesValidator;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class InformacoesNotaFiscal extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'infNFe';

    public VersaoDocumentoFiscal $versao;
    public IdentificacaoNotaFiscal $ide;
    public Emitente $emit;
    public ?Destinatario $dest;
    public DetalhamentoItemCollection $detCollection;
    public TotalNotaFiscal $total;
    public InformacoesTransporte $transp;
    public InformacoesPagamento $pag;

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [
            new RequiredAttributeValidator(['Id', 'versao']),
            new AllowedAttributesValidator(['Id', 'versao']),
        ];
    }

    /** @return array<Validator> */
    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['ide', 'emit', 'det', 'total', 'transp', 'pag']),
            new AllowedTagsValidator(['ide', 'emit', 'avulsa', 'dest', 'retirada', 'entrega', 'autXML', 'det', 'total', 'transp', 'cobr', 'pag', 'infIntermed', 'infAdic', 'exporta', 'compra', 'cana', 'infRespTec']),
        ];
    }
}
