<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Invoices\Validators\MaxDFeCollectionSizeValidator;

class DetalhamentoItemCollection extends DFeElementCollection
{
    protected const string BASE_CLASS = DetalhamentoItem::class;

    protected function collectionValidators(): array
    {
        return [
            new MaxDFeCollectionSizeValidator(990),
        ];
    }
}
