<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\Validators\IsDecimalValidator;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;

class VersaoDocumentoFiscal extends DFeAttribute
{
    public const string FIELD_NAME = 'versao';

    /** @return Validator[] */
    public function attributeValueValidators(): array
    {
        return [
            new IsDecimalValidator(1, 2),
        ];
    }
}
