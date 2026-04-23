<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       E16a
 * Campo    indIEDest
 * Desc     Indicador da IE do Destinatário
 * Tam      1
 * OBS:
 * 1=Contribuinte ICMS (informar a IE do destinatário);
 * 2=Contribuinte isento de Inscrição no cadastro de Contribuintes
 * 9=Não Contribuinte, que pode ou não possuir Inscrição Estadual
 * no Cadastro de Contribuintes do ICMS.
 * Nota 1: No caso de NFC-e informar indIEDest=9 e não informar a
 * tag IE do destinatário;
 * Nota 2: No caso de operação com o Exterior informar indIEDest=9 e
 * não informar a tag IE do destinatário;
 * Nota 3: No caso de Contribuinte Isento de Inscrição (indIEDest=2), não
 * informar a tag IE do destinatário.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoIndIEDestinatarioValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class IndicadorIEDestinatario extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string TAG_NAME = 'indIEDest';

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
            new IsTipoIndIEDestinatarioValidator,
        ];
    }
}
