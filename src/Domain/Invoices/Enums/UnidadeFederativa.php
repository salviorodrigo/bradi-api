<?php

declare(strict_types=1);

/*
 * Tabela de sigla de Unidade Federativa, de acordo com a tabela do IBGE de de
 * código de unidades da federação (Seção 8.1 do MOC – Visão
 * Geral, Tabela de UF, Município e País) de 10 de fevereiro de 2025.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum UnidadeFederativa: string
{
    case RO = '11';
    case AC = '12';
    case AM = '13';
    case RR = '14';
    case PA = '15';
    case AP = '16';
    case TO = '17';
    case MA = '21';
    case PI = '22';
    case CE = '23';
    case RN = '24';
    case PB = '25';
    case PE = '26';
    case AL = '27';
    case SE = '28';
    case BA = '29';
    case MG = '31';
    case ES = '32';
    case RJ = '33';
    case SP = '35';
    case PR = '41';
    case SC = '42';
    case RS = '43';
    case MS = '50';
    case MT = '51';
    case GO = '52';
    case DF = '53';
    case EX = '99';
}
