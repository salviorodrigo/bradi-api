<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Traits;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiApi\Domain\Invoices\Validators\HasNoTextContentValidator;

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
