<?php

declare(strict_types=1);

/*
 * Tabela de modalidade do frete, de
 * acordo com MOC 7.0, campo modFrete.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum CodigoModalidadeFrete: string
{
    case ContratacaoFreteRemetente = '0';
    case ContratacaoFreteDestinatario = '1';
    case ContratacaoFreteTerceiros = '2';
    case TransporteProprioRemetente = '3';
    case TransporteProprioDestinatario = '4';
    case SemOcorrenciaTransporte = '9';
}
