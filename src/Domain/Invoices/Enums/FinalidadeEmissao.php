<?php

declare(strict_types=1);

/*
 * Tabela de finalidade nota fiscal, de
 * acordo com  MOC 7.0, campo finNFe.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum FinalidadeEmissao: string
{
    case Normal = '1';
    case Complementar = '2';
    case Ajuste = '3';
    case Devolucao = '4';
}
