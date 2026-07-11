<?php

declare(strict_types=1);

/*
 * Tabela de ambiente de emissao de
 * documento fiscal, de acordo com
 * MOC 7.0, campo tpAmb.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum AmbienteEmissao: string
{
    case Producao = '1';
    case Homologacao = '2';
}
