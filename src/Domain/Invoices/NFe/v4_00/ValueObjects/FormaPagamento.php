<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       YA01b
 * Campo    indPag
 * Desc     Indicador da Forma de Pagamento
 * Tam      0-1
 * OBS:
 * 0= Pagamento à Vista 1= Pagamento à Prazo
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsIntegerValidator;
use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

class FormaPagamento extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'indPag';

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new MaxValueValidator(1),
            new MinValueValidator(0),
            new IsIntegerValidator,
        ];
    }
}
