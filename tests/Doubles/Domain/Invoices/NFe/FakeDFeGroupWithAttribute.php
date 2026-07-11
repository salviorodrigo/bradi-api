<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeElement;

final class FakeDFeGroupWithAttribute extends DFeElement
{
    public const string FIELD_NAME = 'FakeGroup';

    public FakeDFeAttribute $fakeAttr;
    public FakeDFeElement $fakeChild;
    public ?FakeDFeElement $fakeOptionalChild;

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
