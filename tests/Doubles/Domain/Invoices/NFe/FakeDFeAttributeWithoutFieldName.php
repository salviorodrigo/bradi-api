<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;

/**
 * Filha invalida de proposito: nao declara FIELD_NAME, entao herda a string vazia de DFeAttribute.
 * Instanciar deve ser barrado pelo guard clause do construtor.
 */
final class FakeDFeAttributeWithoutFieldName extends DFeAttribute
{
    /** @return array<Validator> */
    protected function attributeValueValidators(): array
    {
        return [];
    }
}
