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

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPessoaFisica;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPessoaJuridica;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeFantasia;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiApi\Domain\Invoices\Validators\RequiredTagsValidator;

final class Emitente extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string FIELD_NAME = 'emit';

    public CodigoPessoaJuridica $CNPJ;
    public ?CodigoPessoaFisica $CPF;
    public Nome $xNome;
    public ?NomeFantasia $xFant;
    public InscricaoEstadual $IE;
    public EnderecoEmitente $enderEmit;

    protected function tagElementsValidators(): array
    {
        return [
            new RequiredTagsValidator(['CNPJ', 'xNome', 'enderEmit', 'IE', 'CRT']),
        ];
    }
}
