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

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoBarras;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoFiscal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMercosul;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoProduto;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\DescricaoProduto;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\QuantidadeComercial;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\UnidadeComercial;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorTotalProduto;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorUnitarioComercial;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Produto extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'prod';

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
            new RequiredTagValidator(['cProd', 'cEAN', 'xProd', 'NCM', 'CFOP', 'uCom', 'qCom', 'vUnCom', 'vProd']),
        ];
    }
}
