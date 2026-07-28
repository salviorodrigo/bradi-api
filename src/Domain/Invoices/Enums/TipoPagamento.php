<?php

declare(strict_types=1);

/*
 * Indica operação com Consumidor final, de
 * acordo com  MOC 7.0, campo tPag.
 */

namespace BradiApi\Domain\Invoices\Enums;

enum TipoPagamento: string
{
    case Dinheiro = '01';
    case Cheque = '02';
    case CartaoDeCredito = '03';
    case CartaoDeDebito = '04';
    case CreditoLoja = '05';
    case ValeAlimentacao = '10';
    case ValeRefeicao = '11';
    case ValePresente = '12';
    case ValeCombustivel = '13';
    case BoletoBancario = '15';
    case DepositoBancario = '16';
    case PagamentoInstantaneoPIX = '17';
    case TransferenciaBancariaCarteiraDigital = '18';
    case ProgramaDeFidelidadeCashbackCreditoVirtual = '19';
    case SemPagamento = '90';
    case Outros = '99';
}
