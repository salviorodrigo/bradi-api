<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        34
 * ID       C05
 * Campo    enderEmit
 * Desc     Endereço do emitente
 * Tam
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Bairro;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipio;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPais;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPostal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ComplementoEndereco;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Logradouro;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeMunicipio;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomePais;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroEndereco;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\SiglaUF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Telefone;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class EnderecoEmitente extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string TAG_NAME = 'enderEmit';

    public Logradouro $xLgr;
    public NumeroEndereco $nro;
    public ?ComplementoEndereco $Cpl;
    public Bairro $xBairro;
    public CodigoMunicipio $cMun;
    public NomeMunicipio $xMun;
    public SiglaUF $UF;
    public CodigoPostal $CEP;
    public ?CodigoPais $cPais;
    public ?NomePais $xPais;
    public ?Telefone $fone;

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? static::TAG_NAME : $parentFieldURI . '.' . static::TAG_NAME;
    }

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP']),
        ];
    }
}
