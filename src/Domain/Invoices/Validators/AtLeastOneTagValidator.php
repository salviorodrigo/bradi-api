<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class AtLeastOneTagValidator implements Validator
{
    public function __construct(
        public readonly array $requiredTagNames,
        public readonly array $providedTagNames
    ) {}

    public function check(mixed $candidate): Result
    {
        if (array_intersect($this->requiredTagNames, $this->providedTagNames) === []) {
            return Result::makeFailure(new InvalidArgumentException(sprintf(
                'At least one of the following tags must be informed: %s.',
                implode(', ', $this->requiredTagNames)
            )));
        }

        return Result::makeSuccess();
    }
}
