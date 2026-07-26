<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        -
 * ID       N02
 * Campo    ICMS00
 * Desc     Grupo do ICMS 00
 * Tam
 * OBS:
 * Origem da mercadoria, CST, modalidade de BC, valor da BC,
 * aliquota e valor do ICMS da operacao propria.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\AliquotaICMS;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorOrigemMercadoria;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeBaseDeCalculo;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorBaseDeCalculo;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class Icms00 extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'ICMS00';

    public IndicadorOrigemMercadoria $orig;
    public CodigoSituacaoTributaria $CST;
    public ModalidadeBaseDeCalculo $modBC;
    public ValorBaseDeCalculo $vBC;
    public AliquotaICMS $pICMS;
    public ValorICMS $vICMS;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['orig', 'CST', 'modBC', 'vBC', 'pICMS', 'vICMS']),
            new AllowedTagsValidator(['orig', 'CST', 'modBC', 'vBC', 'pICMS', 'vICMS', 'pFCP', 'vFCP']),
        ];
    }
}
