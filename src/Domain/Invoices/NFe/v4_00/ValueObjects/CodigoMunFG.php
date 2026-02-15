<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        16
 * ID       B12
 * Campo    cMunFG
 * Desc     Código do Município de Ocorrência do Fato Gerador
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Invoices\Protocols\HasValue;

final class CodigoMunFG extends CodigoMunicipio implements HasValue
{
    public static string $tagName = 'cMunFG';
}
