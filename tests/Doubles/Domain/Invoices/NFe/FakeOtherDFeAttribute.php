<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;

final class FakeOtherDFeAttribute extends DFeAttribute
{
    public const string FIELD_NAME = 'otherAttr';

    /** @return array<Validator> */
    protected function attributeValueValidators(): array
    {
        return [];
    }
}
