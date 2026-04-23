<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Traits;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoTextContentValidator;

trait ValidatesDFeGroupElement
{
    /** @return array<Validator> */
    protected function tagValueValidators(): array
    {
        return [new HasNoTextContentValidator];
    }

    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [new HasNoAttributesValidator];
    }
}
