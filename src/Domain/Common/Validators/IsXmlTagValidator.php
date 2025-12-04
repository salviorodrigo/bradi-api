<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotXmlTagError;

final class IsXmlTagValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (is_string($candidate) && simplexml_load_string($candidate)) {
            return Result::makeSuccess();
        }

        return Result::makeFailure(new IsNotXmlTagError($this->fieldName));
    }
}
