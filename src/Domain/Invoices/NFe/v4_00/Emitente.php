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

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeFantasia;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Emitente extends DFeElement
{
    use ValidatesDFeGroupElement;

    public const string TAG_NAME = 'emit';

    public ?CadastroPJ $CNPJ;
    public ?CadastroPF $CPF;
    public Nome $xNome;
    public ?NomeFantasia $xFant;
    public EnderecoEmitente $endEmit;
    public InscricaoEstadual $IE;

    protected function tagElementsValidators(): array
    {
        return [
            new AtLeastOneTagValidator(['CNPJ', 'CPF']),
            new RequiredTagValidator(['xNome', 'enderEmit', 'IE', 'CRT']),
        ];
    }
}
