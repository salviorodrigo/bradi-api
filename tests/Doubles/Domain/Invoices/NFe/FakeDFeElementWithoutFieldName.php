<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeElement;

/**
 * Filha invalida de proposito: nao declara FIELD_NAME, entao herda o null de DFeElement.
 * Instanciar lanca TypeError na atribuicao de $fieldURI, antes do guard clause do construtor.
 */
final class FakeDFeElementWithoutFieldName extends DFeElement
{
    /** @return array<Validator> */
    protected function tagValueValidators(): array
    {
        return [];
    }

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [];
    }

    /** @return array<Validator> */
    protected function tagElementsValidators(): array
    {
        return [];
    }
}
