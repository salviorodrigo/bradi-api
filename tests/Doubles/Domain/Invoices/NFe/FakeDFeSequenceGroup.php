<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Templates\DFeElement;

final class FakeDFeSequenceGroup extends DFeElement
{
    public const string FIELD_NAME = 'FakeSeq';
    public const array CHILD_ELEMENTS_ON_SEQUENCE = ['FakeTag', 'FakeOther'];
    public const array CHILD_ATTRIBUTES_ON_SEQUENCE = ['fakeAttr', 'otherAttr'];

    public ?FakeOtherDFeElement $second;
    public ?FakeDFeElement $first;
    public ?FakeOtherDFeAttribute $otherAttr;
    public ?FakeDFeAttribute $fakeAttr;

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
