<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Invoices\Templates\DFeElementCollection;

final class FakeDFeElementCollection extends DFeElementCollection
{
    public const string BASE_CLASS = FakeDFeElement::class;
}
