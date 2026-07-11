<?php

declare(strict_types=1);

/*
 * Tabela de modalidade de determinacao da BC do ICMS, de
 * acordo com MOC 7.0, campo modBC.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum TipoModalidadeBC: string
{
    case MargemValorAgregado = '0';
    case Pauta = '1';
    case PrecoTabeladoMaximo = '2';
    case ValorOperacao = '3';
}
