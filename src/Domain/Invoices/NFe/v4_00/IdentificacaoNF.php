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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipioFatoGerador;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdDestino;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndFinal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModeloDFe;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NaturezaOperacao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

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
