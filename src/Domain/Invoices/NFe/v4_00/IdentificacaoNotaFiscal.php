<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        5
 * ID       B01
 * Campo    ide
 * Desc     Informações de identificação da NF-e
 * Tam
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoModeloDocumentoFiscal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipioFatoGerador;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNotaFiscal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUnidadeFederativa;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNotaFiscal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdentificadorDestinoOperacao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdentificadorOperacaoConsumidorFinal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NaturezaOperacao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNotaFiscal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class IdentificacaoNotaFiscal extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'ide';

    public CodigoUnidadeFederativa $cUF;
    public CodigoNotaFiscal $cNF;
    public NaturezaOperacao $natOp;
    public CodigoModeloDocumentoFiscal $mod;
    public Serie $serie;
    public NumeroNotaFiscal $nNF;
    public DataHoraEmissao $dhEmi;
    public TipoNotaFiscal $tpNF;
    public IdentificadorDestinoOperacao $idDest;
    public CodigoMunicipioFatoGerador $cMunFG;
    public TipoEmissao $tpEmis;
    public TipoAmbiente $tpAmb;
    public FinalidadeNotaFiscal $finNFe;
    public IdentificadorOperacaoConsumidorFinal $indFinal;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['cUF', 'cNF', 'natOp', 'mod', 'serie', 'nNF', 'dhEmi', 'tpNF', 'idDest', 'cMunFG', 'tpImp', 'tpEmis', 'cDV', 'tpAmb', 'finNFe', 'indFinal', 'indPres', 'procEmi', 'verProc']),
            new AllowedTagsValidator(['cUF', 'cNF', 'natOp', 'mod', 'serie', 'nNF', 'dhEmi', 'dhSaiEnt', 'tpNF', 'idDest', 'cMunFG', 'tpImp', 'tpEmis', 'cDV', 'tpAmb', 'finNFe', 'indFinal', 'indPres', 'indIntermed', 'procEmi', 'verProc', 'dhCont', 'xJust']),
        ];
    }
}
