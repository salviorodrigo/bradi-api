<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        62
 * ID       E01
 * Campo    dest
 * Desc     Identificação do destinatario da NF-e
 * Tam
 * OBS:
 * Grupo Obrigatório para a NF-e (modelo 55).
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorIEDestinatario;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Destinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'dest';

    public ?CadastroPJ $CNPJ;
    public ?CadastroPF $CPF;
    public ?Nome $xNome;
    public ?EnderecoDestinatario $enderDest;
    public IndicadorIEDestinatario $indIEDest;
    public ?InscricaoEstadual $IE;

    protected function tagElementsValidators(): array
    {
        return [
            new AtLeastOneTagValidator(['CNPJ', 'CPF', 'idEstrangeiro']),
            new RequiredTagValidator(['indIEDest']),
        ];
    }
}
