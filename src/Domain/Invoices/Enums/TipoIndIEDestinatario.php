<?php

declare(strict_types=1);

/*
 * Tabela de tipo de emissao de nota fiscal, de
 * acordo com  MOC 7.0, campo indIEDest.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum TipoIndIEDestinatario: string
{
    case ContribuinteICMS = '1';
    case Isento = '2';
    case NaoContribuinteICMS = '9';
}
