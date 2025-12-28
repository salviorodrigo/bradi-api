<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\ModeloDFe;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidModError;

final class IsModeloDFeValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) ModeloDFe::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidModError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
