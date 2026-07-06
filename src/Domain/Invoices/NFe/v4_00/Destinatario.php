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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorIEDestinatario;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Destinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string TAG_NAME = 'dest';

    public ?CadastroPJ $CNPJ;
    public ?CadastroPF $CPF;
    public ?Nome $xNome;
    public ?EnderecoDestinatario $endDest;
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
