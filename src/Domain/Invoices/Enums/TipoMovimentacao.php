<?php

declare(strict_types=1);

/*
 * Tabela de tipo de movimentacao de nota fiscal, de
 * acordo com  MOC 7.0, campo tpNF.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum TipoMovimentacao: string
{
    case Entrada = '0';
    case Saida = '1';
}
