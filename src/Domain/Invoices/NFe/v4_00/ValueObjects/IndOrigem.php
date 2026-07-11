<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N11
 * Campo    orig
 * Desc     Indica a origem da mercadoria
 * Tam      1
 * OBS:
 * 0=Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8;
 * 1=Estrangeira - Importação direta, exceto a indicada no código 6;
 * 2=Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7;
 * 3=Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%;
 * 4=Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos;
 * 5=Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%;
 * 6=Estrangeira - Importação direta, sem similar nacional, constante em lista CAMEX;
 * 7=Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista CAMEX;
 * 8=Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%.
 */

namespace BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoOrigemMercadoriaValidator;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class IndOrigem extends DFeElement
{
    use ValidatesDFeValueElement;

    public const string FIELD_NAME = 'orig';

    protected function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoOrigemMercadoriaValidator,
        ];
    }
}
