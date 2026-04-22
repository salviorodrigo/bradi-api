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
    ) {}

    public function check(mixed $candidate): Result
    {
        $providedTagNames = is_array($candidate) ? array_keys($candidate) : [];
        if (array_intersect($this->requiredTagNames, $providedTagNames) === []) {
            return Result::makeFailure(new InvalidArgumentException(sprintf(
                'At least one of the following tags must be informed: %s.',
                implode(', ', $this->requiredTagNames)
            )));
        }

        return Result::makeSuccess();
    }
}
