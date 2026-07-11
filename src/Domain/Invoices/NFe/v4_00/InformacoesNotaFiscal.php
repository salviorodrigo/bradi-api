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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;
use BradiNfeApi\Domain\Invoices\Validators\HasNoTextContentValidator;

final class InformacoesNotaFiscal extends DFeElement
{
    public const string FIELD_NAME = 'infNFe';

    /** @return array<Validator> */
    protected function tagValueValidators(): array
    {
        return [new HasNoTextContentValidator];
    }

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [];
    }

    /** @return array<Validator> */
    protected function tagElementsValidators(): array
    {
        return [];
    }
}
