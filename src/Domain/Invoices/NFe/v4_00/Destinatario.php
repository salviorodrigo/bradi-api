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

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPessoaFisica;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPessoaJuridica;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorTipoDestinatario;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\AllowedTagsValidator;
use BradiApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class Destinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'dest';

    public ?CodigoPessoaJuridica $CNPJ;
    public ?CodigoPessoaFisica $CPF;
    public ?Nome $xNome;
    public ?EnderecoDestinatario $enderDest;
    public IndicadorTipoDestinatario $indIEDest;
    public ?InscricaoEstadual $IE;

    protected function tagElementsValidators(): array
    {
        return [
            new AtLeastOneTagValidator(['CNPJ', 'CPF', 'idEstrangeiro']),
            new RequiredTagsValidator(['indIEDest']),
            new AllowedTagsValidator(['CNPJ', 'CPF', 'idEstrangeiro', 'xNome', 'enderDest', 'indIEDest', 'IE', 'IM', 'ISUF', 'email']),
        ];
    }
}
