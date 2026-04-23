<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B08
 * Campo    nNF
 * Desc     Número do Documento Fiscal
 * Tam      1-9
 * OBS:
 * Número do Documento Fiscal
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NumeroNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'nNF';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new MaxStringLengthValidator(9),
            new MinValueValidator(1),
        ];
    }
}
