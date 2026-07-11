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

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipioFatoGerador;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdDestino;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndFinal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModeloDFe;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NaturezaOperacao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class IdentificacaoNF extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'ide';

    public CodigoUF $cUF;
    public CodigoNF $cNF;
    public NaturezaOperacao $natOp;
    public ModeloDFe $mod;
    public Serie $serie;
    public NumeroNF $nNF;
    public DataHoraEmissao $dhEmi;
    public TipoNF $tpNF;
    public IdDestino $idDest;
    public CodigoMunicipioFatoGerador $cMunFG;
    public TipoEmissao $tpEmis;
    public TipoAmbiente $tpAmb;
    public FinalidadeNF $finNFe;
    public IndFinal $indFinal;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['cUF', 'cNF', 'natOp', 'mod', 'serie', 'nNF', 'dhEmi', 'tpNF', 'idDest', 'cMunFG', 'tpImp', 'tpEmis', 'cDV', 'tpAmb', 'finNFe', 'indFinal', 'indPres', 'procEmi', 'verProc']),
        ];
    }
}
