<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       Q08
 * Campo    pPIS
 * Desc     Aliquota do PIS (em percentual)
 * Tam      3v2-4
 * OBS:
 * Percentual da aliquota do PIS.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class AliquotaPIS extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'pPIS';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(3, 4),
            new MaxValueValidator(100),
            new MinValueValidator(0),
        ];
    }
}
