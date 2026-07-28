<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsIntegerValidator;
use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

class IndicadorPagamento extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'indPag';

    protected function tagValueValidators(): array
    {
        return [
            new MaxValueValidator(1),
            new MinValueValidator(0),
            new IsIntegerValidator,
        ];
    }
}
