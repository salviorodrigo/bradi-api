<?php

declare(strict_types=1);

/*
 * Tabela de Codigo de Situacao Tributaria, de
 * acordo com MOC 7.0, campo CST.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum TipoSituacaoTributaria: string
{
    case TributadaIntegralmente = '00';
    case TributadaComCobrancaST = '10';
    case ComReducaoBaseCalculo = '20';
    case IsentaOuNaoTributadaComCobrancaST = '30';
    case Isenta = '40';
    case NaoTributada = '41';
    case Suspensao = '50';
    case Diferimento = '51';
    case IcmsCobradoAnteriormentePorST = '60';
    case ComReducaoBaseCalculoECobrancaST = '70';
    case Outras = '90';
}
