<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       YA02
 * Campo    tPag
 * Desc     Meio de Pagamento
 * Tam      1-1
 * OBS:
 * 01=Dinheiro
 * 02=Cheque
 * 03=Cartão de Crédito
 * 04=Cartão de Débito
 * 05=Crédito Loja
 * 10=Vale Alimentação
 * 11=Vale Refeição
 * 12=Vale Presente
 * 13=Vale Combustível
 * 15=Boleto Bancário
 * 16=Depósito Bancário
 * 17=Pagamento Instantâneo (PIX)
 * 18=Transferência bancária, Carteira Digital
 * 19=Programa de fidelidade, Cashback, Crédito Virtual
 * 90= Sem pagamento
 * 99=Outros
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

class MeioDePagamento extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'tPag';

    public function tagValueValidators(): array
    {
        return [
            new IsNumericValidator(allowLeadingZeros: true),
        ];
    }
}
