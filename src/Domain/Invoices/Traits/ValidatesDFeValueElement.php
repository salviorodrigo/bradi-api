<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Traits;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoChildrenValidator;

trait ValidatesDFeValueElement
{
    /** @return array<Validator> */
    protected static function tagAttributesValidators(): array
    {
        return [new HasNoAttributesValidator];
    }

    /** @return array<Validator> */
    protected static function tagElementsValidators(): array
    {
        return [new HasNoChildrenValidator];
    }
}
