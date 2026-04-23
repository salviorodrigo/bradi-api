<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        44
 * ID       C15
 * Campo    cPais
 * Desc     Código país
 * Tam      4
 * OBS:
 * 1058=Brasil/BRASIL
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoPais extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'cPais';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new IsNumericValidator,
            new StringLengthValidator(4),
        ];
    }
}
