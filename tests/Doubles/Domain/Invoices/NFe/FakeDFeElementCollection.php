<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiNfeApi\Domain\Invoices\Templates\DFeElementCollection;

final class FakeDFeElementCollection extends DFeElementCollection
{
    public const string BASE_CLASS = FakeDFeElement::class;
}
