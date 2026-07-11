<?php

declare(strict_types=1);

/*
 * Indica operação com Consumidor final, de
 * acordo com  MOC 7.0, campo indFinal.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum TipoFinalidadeNF: string
{
    case Normal = '0';
    case ConsumoFinal = '1';
}
