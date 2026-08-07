<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeElement;

/**
 * Filha invalida de proposito: declara FIELD_NAME vazio.
 * Instanciar deve ser barrado pelo guard clause do construtor.
 */
final class FakeDFeElementWithEmptyFieldName extends DFeElement
{
    public const ?string FIELD_NAME = '';

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
