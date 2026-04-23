<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B25a
 * Campo    indFinal
 * Desc     Indica operação com Consumidor final
 * Tam      1
 * OBS:
 * 0=Normal;
 * 1=Consumidor final;
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoFinalidadeNFValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class IndFinal extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'indFinal';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoFinalidadeNFValidator,
        ];
    }
}
