<?php

declare(strict_types=1);

/*
 * Tabela de Codigo de Situacao Tributaria, de
 * acordo com MOC 7.0, campo CST.
 */

namespace BradiNfeApi\Domain\Invoices\Enums;

enum TipoSituacaoTributaria: string
{
    case TributavelAliquotaBasica = '01';
    case TributavelAliquotaDiferenciada = '02';
    case TributavelAliquotaPorUnidadeMedida = '03';
    case TributavelMonofasicaRevendaAliquotaZero = '04';
    case TributavelSubstituicaoTributaria = '05';
    case TributavelAliquotaZero = '06';
    case IsentaContribuicao = '07';
    case SemIncidenciaContribuicao = '08';
    case SuspensaoContribuicao = '09';
    case TributadaIntegralmente = '00';
    case TributadaComCobrancaST = '10';
    case ComReducaoBaseCalculo = '20';
    case IsentaOuNaoTributadaComCobrancaST = '30';
    case Isenta = '40';
    case NaoTributada = '41';
    case OutrasOperacoesSaida = '49';
    case Suspensao = '50';
    case Diferimento = '51';
    case Cst52 = '52';
    case Cst53 = '53';
    case Cst54 = '54';
    case Cst55 = '55';
    case Cst56 = '56';
    case IcmsCobradoAnteriormentePorST = '60';
    case Cst61 = '61';
    case Cst62 = '62';
    case Cst63 = '63';
    case Cst64 = '64';
    case Cst65 = '65';
    case Cst66 = '66';
    case Cst67 = '67';
    case ComReducaoBaseCalculoECobrancaST = '70';
    case OperacaoAquisicaoSemDireitoCreditoContribuicao = '71';
    case OperacaoAquisicaoComIsencaoContribuicao = '72';
    case OperacaoAquisicaoComSuspensaoContribuicao = '73';
    case OperacaoAquisicaoAliquotaZeroContribuicao = '74';
    case OperacaoAquisicaoSemIncidenciaContribuicao = '75';
    case OutrasOperacoesEntrada = '98';
    case OutrasOperacoes = '99';
    case Outras = '90';
}
