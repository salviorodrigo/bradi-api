<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Traits;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoTextContentValidator;

trait ValidatesDFeGroupElement
{
    /** @return array<Validator> */
    protected static function tagValueValidators(): array
    {
        return [new HasNoTextContentValidator];
    }

    /** @return array<Validator> */
    protected static function tagAttributesValidators(): array
    {
        return [new HasNoAttributesValidator];
    }
}
