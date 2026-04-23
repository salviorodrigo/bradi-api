<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeAttribute;

final class FakeDFeAttribute extends DFeAttribute
{
    public const string ATTRIBUTE_NAME = 'fakeAttr';

    /** @return array<Validator> */
    protected function attributeValueValidators(): array
    {
        return [];
    }
}
