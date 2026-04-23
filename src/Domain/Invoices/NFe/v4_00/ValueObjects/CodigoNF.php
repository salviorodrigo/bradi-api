<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B03
 * Campo    cNF
 * Desc     Código Numérico que compõe a Chave de Acesso
 * Tam      8
 * OBS:
 * Código numérico que compõe a Chave de Acesso. Número aleatório
 * gerado pelo emitente para cada NF-e para evitar acessos
 * indevidos da NF-e. (v2.0)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Invoices\NFe\Validators\IsCodigoNFValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'cNF';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new IsCodigoNFValidator,
        ];
    }
}
