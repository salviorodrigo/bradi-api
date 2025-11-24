<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class RequiredTagValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (DFeElement::xmlParser()->getTag($candidate, $fieldName) == '') {
            return Result::makeFailure(new IsNotXmlTagError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}
