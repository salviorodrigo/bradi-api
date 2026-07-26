<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        327
 * ID       W02
 * Campo    ICMSTot
 * Desc     Grupo Totais referentes ao ICMS
 * Tam      1-1
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorBaseDeCalculo;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorCOFINS;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorDesconto;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorDespesasAcessorias;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorFrete;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorPIS;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorProduto;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorSeguro;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class IcmsNotaFiscal extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'ICMSTot';

    public ValorBaseDeCalculo $vBC;
    public ValorICMS $vICMS;
    public ValorProduto $vProd;
    public ValorFrete $vFrete;
    public ValorSeguro $vSeg;
    public ValorDesconto $vDesc;
    public ValorPIS $vPIS;
    public ValorCOFINS $vCOFINS;
    public ValorDespesasAcessorias $vOutro;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['vBC', 'vICMS', 'vICMSDeson', 'vFCP', 'vBCST', 'vST', 'vFCPST', 'vFCPSTRet', 'vProd', 'vFrete', 'vSeg', 'vDesc', 'vII', 'vIPI', 'vIPIDevol', 'vPIS', 'vCOFINS', 'vOutro', 'vNF',
            ]),
            new AllowedTagsValidator(['vBC', 'vICMS', 'vICMSDeson', 'vFCPUFDest', 'vICMSUFDest', 'vICMSUFRemet', 'vFCP', 'vBCST', 'vST', 'vFCPST', 'vFCPSTRet', 'vProd', 'vFrete', 'vSeg', 'vDesc', 'vII', 'vIPI', 'vIPIDevol', 'vPIS', 'vCOFINS', 'vOutro', 'vNF', 'vTotTrib',
            ]),
        ];
    }
}
