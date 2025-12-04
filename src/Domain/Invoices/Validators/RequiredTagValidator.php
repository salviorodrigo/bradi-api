<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Validators\Exceptions\NotFoundTagError;

final class RequiredTagValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (DFeElement::xmlParser()->getTag($candidate, $this->fieldName) == '') {
            return Result::makeFailure(new NotFoundTagError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}
