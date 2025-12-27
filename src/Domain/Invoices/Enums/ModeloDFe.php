<?php

declare(strict_types=1);

/*
 * Tabela de modelo de documento fiscal, de
 * acordo com  MOC 7.0, campo mod.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum ModeloDFe: string
{
    case NFe = '55';
    case NFCe = '65';
}
