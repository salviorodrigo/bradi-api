<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Traits;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiApi\Domain\Invoices\Validators\HasNoChildrenValidator;

trait ValidatesDFeValueElement
{
    /** @return array<Validator> */
    protected function tagAttributesValidators(): array
    {
        return [new HasNoAttributesValidator];
    }

    /** @return array<Validator> */
    protected function tagElementsValidators(): array
    {
        return [new HasNoChildrenValidator];
    }
}
