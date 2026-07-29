<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\Validators\MaxDFeCollectionSizeValidator;

class DetalhamentoPagamentoCollection extends DFeElementCollection
{
    protected const string BASE_CLASS = DetalhamentoPagamento::class;
    protected const string FIELD_NAME = 'detPag';

    protected function collectionValidators(): array
    {
        return [
            new MaxDFeCollectionSizeValidator(100),
        ];
    }
}
