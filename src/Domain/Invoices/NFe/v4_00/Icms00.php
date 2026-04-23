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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\AliquotaICMS;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndOrigem;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Icms00 extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string TAG_NAME = 'ICMS00';

    public IndOrigem $orig;
    public CodigoSituacaoTributaria $CST;
    public ModalidadeBC $modBC;
    public ValorBC $vBC;
    public AliquotaICMS $pICMS;
    public ValorICMS $vICMS;

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['orig', 'CST', 'modBC', 'vBC', 'pICMS', 'vICMS']),
        ];
    }
}
