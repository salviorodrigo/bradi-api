<?php

declare(strict_types=1);

/*
 * Tabela de tipo de emissao de nota fiscal, de
 * acordo com  MOC 7.0, campo tpEmis.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum TipoEmissaoNF: string
{
    case Normal = '1';
    case ContFS_IA = '2';
    case ContSCAN = '4';
    case ContEPEC = '3';
    case ContFS_DA = '5';
    case ContSVC_AN = '6';
    case ContSVC_RS = '7';
    case ContNFCe = '9';
}
