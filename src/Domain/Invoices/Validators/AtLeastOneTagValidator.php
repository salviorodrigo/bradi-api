<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class AtLeastOneTagValidator implements Validator
{
    public function __construct(
        public readonly array $requiredTagNames,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        $providedTagNames = array_map(
            fn (Element $element) => $element->name,
            $candidate->children->records,
        );
        if (array_intersect($this->requiredTagNames, $providedTagNames) === []) {
            return Result::makeFailure(new InvalidArgumentException(sprintf(
                'At least one of the following tags must be informed: %s.',
                implode(', ', $this->requiredTagNames)
            )));
        }

        return Result::makeSuccess();
    }
}
