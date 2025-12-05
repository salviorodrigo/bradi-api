<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\ValidatorError;

final class XmlElementWithAttributesError extends ValidatorError
{
    public function __construct(public readonly string $fieldName)
    {
        $this->message = 'this xml element doesn\'t contain attributes.';
    }
}
