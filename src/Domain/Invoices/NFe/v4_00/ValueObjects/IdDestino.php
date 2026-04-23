<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B11a
 * Campo    idDest
 * Desc     Identificador de local de destino da operação
 * Tam      1
 * OBS:
 * 1=Operação interna;
 * 2=Operação interestadual;
 * 3=Operação com exterior.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoOperacaoValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class IdDestino extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'idDest';

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
            new IsTipoOperacaoValidator,
        ];
    }
}
