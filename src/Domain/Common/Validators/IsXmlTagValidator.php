<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotXmlTagError;

final class IsXmlTagValidator extends Validator
{
    public function __construct(public readonly string $fieldName, private bool $isAutoClosedTag = false) {}

    public function validate(mixed $candidate): Result
    {
        if (! str_starts_with($candidate, '<' . $this->fieldName)) {
            return Result::makeFailure(new IsNotXmlTagError($this->fieldName));
        }

        if ($this->isAutoClosedTag) {
            if (! str_ends_with($candidate, '/>')) {
                return Result::makeFailure(new IsNotXmlTagError($this->fieldName));
            }
        } else {
            if (! str_ends_with($candidate, '</' . $this->fieldName . '>')) {
                return Result::makeFailure(new IsNotXmlTagError($this->fieldName));
            }
        }

        return Result::makeSuccess();
    }
}
