<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        66
 * ID       E05
 * Campo    enderDest
 * Desc     Endereço do destinatario
 * Tam
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Bairro;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipio;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPais;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPostal;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ComplementoEndereco;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Logradouro;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeMunicipio;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomePais;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroEndereco;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\SiglaUF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Telefone;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class EnderecoDestinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'enderDest';

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

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP']),
        ];
    }
}
