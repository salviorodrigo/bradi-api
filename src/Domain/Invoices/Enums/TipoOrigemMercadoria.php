<?php

declare(strict_types=1);

/*
 * Indica a origem da mercadoria, de
 * acordo com MOC 7.0, campo orig.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum TipoOrigemMercadoria: string
{
    case Nacional = '0';
    case EstrangeiraImportacaoDireta = '1';
    case EstrangeiraMercadoInterno = '2';
    case NacionalConteudoImportacaoSuperior40 = '3';
    case NacionalProcessosProdutivosBasicos = '4';
    case NacionalConteudoImportacaoInferior40 = '5';
    case EstrangeiraImportacaoDiretaSemSimilarNacional = '6';
    case EstrangeiraMercadoInternoSemSimilarNacional = '7';
    case NacionalConteudoImportacaoSuperior70 = '8';
}
