<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        44
 * ID       C15
 * Campo    xPais
 * Desc     Nome Pais
 * Tam      1-60
 * OBS:
 * Tag opcional.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class NomePais extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'xPais';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(2),
            new TextFormatValidator,
        ];

    }
}
