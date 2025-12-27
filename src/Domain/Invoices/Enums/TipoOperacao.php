<?php

declare(strict_types=1);

/*
 * Tabela de tipo de operacao de nota fiscal, de
 * acordo com  MOC 7.0, campo idDest.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum TipoOperacao: string
{
    case OperacaoInterna = '1';
    case OperacaoInternaInterEstadual = '2';
    case OperacaoInternaExterior = '3';
}
