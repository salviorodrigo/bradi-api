<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        14
 * ID       B10
 * Campo    dhSaiEnt
 * Desc     Data e hora de Saída ou da Entrada da Mercadoria/Produto
 * Tam
 * OBS:
 * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD;
 * Não informar este campo para a NFC-e.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

final class DataHoraSaidaEntrada extends DataHoraEmissao
{
    public static string $tagName = 'dhSaiEnt';

}
