<?php

declare(strict_types=1);

/*
 * Tabela de tipo de movimentacao de nota fiscal, de
 * acordo com  MOC 7.0, campo tpNF.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum FinalidadeNF: string
{
    case Normal = '0';
    case ConsumoFinal = '1';
}
