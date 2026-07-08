<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        100
 * ID       I01
 * Campo    prod
 * Desc     Detalhamento de Produtos e Serviços
 * Tam      1-1
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoBarras;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoFiscal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMercosul;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoProduto;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DescricaoProduto;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\QuantidadeComercial;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\UnidadeComercial;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorTotalProduto;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorUnitarioComercial;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Produto extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string TAG_NAME = 'prod';

    public CodigoProduto $cProd;
    public CodigoBarras $cEAN;
    public DescricaoProduto $xProd;
    public CodigoMercosul $NCM;
    public CodigoFiscal $CFOP;
    public UnidadeComercial $uCom;
    public QuantidadeComercial $qCom;
    public ValorUnitarioComercial $vUnCom;
    public ValorTotalProduto $vProd;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator([ 'cProd', 'cEAN', 'xProd', 'NCM', 'CFOP', 'uCom', 'qCom', 'vUnCom', 'vProd' ]),
        ];
    }
}
