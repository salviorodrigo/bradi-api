<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\ModeloDFe;
use BradiNfeApi\Domain\Invoices\Exceptions\InvalidModeloDFeError;

final class IsModeloDFeValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) ModeloDFe::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidModeloDFeError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
