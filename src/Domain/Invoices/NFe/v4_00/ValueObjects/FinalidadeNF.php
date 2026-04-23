<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B25
 * Campo    finNFe
 * Desc     Finalidade de emissão da NF-e
 * Tam      1
 * OBS:
 * 1=NF-e normal;
 * 2=NF-e complementar;
 * 3=NF-e de ajuste;
 * 4=Devolução de mercadoria.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsFinalidadeEmissaoValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class FinalidadeNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'finNFe';

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(1),
            new IsFinalidadeEmissaoValidator,
        ];
    }
}
