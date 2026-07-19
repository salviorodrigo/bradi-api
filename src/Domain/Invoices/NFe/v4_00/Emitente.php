<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        30
 * ID       C01
 * Campo    emit
 * Desc     Identificação do emitente da NF-e
 * Tam
 * OBS:
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00;

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeFantasia;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Emitente extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'emit';

    public CadastroPJ $CNPJ;
    public ?CadastroPF $CPF;
    public Nome $xNome;
    public ?NomeFantasia $xFant;
    public InscricaoEstadual $IE;
    public EnderecoEmitente $enderEmit;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['CNPJ', 'xNome', 'enderEmit', 'IE', 'CRT']),
        ];
    }
}
