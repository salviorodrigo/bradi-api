<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Traits;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Validators\HasNoAttributesValidator;
use BradiNfeApi\Domain\Invoices\Validators\HasNoChildrenValidator;

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
