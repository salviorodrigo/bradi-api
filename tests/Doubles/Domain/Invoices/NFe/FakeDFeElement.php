<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class FakeDFeElement extends DFeElement
{
    public const string TAG_NAME = 'FakeTag';

    public function __construct(string $value = 'fakeValue')
    {
        $this->value = $value;
        $this->xmlString = '<' . self::TAG_NAME . '>' . $value . '</' . self::TAG_NAME . '>';
        $this->fieldURI = self::TAG_NAME;
    }

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
