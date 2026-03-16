<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Exceptions\NotFoundAtLeastOneTagError;

final class AtLeastOneTagValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly array $requiredTagNames,
        public readonly array $providedTagNames
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (array_intersect($this->requiredTagNames, $this->providedTagNames) === []) {
            return Result::makeFailure(new NotFoundAtLeastOneTagError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->requiredTagNames
            ));
        }

        return Result::makeSuccess();
    }
}
