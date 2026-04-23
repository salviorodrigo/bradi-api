<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C17
 * Campo    IE
 * Desc     Inscrição Estadual
 * Tam      2-14
 * OBS:
 * Informar somente os algarismos, sem os caracteres
 * de formatação (ponto, barra, hífen, etc.).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class InscricaoEstadual extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'IE';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator(allowLeadingZeros: true),
            new MaxStringLengthValidator(maxStringLength: 14),
            new MinStringLengthValidator(minStringLength: 2),
        ];
    }
}
