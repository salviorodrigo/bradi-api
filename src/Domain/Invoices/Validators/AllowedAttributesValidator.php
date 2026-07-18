<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class AllowedAttributesValidator implements Validator
{
    public function __construct(
        public readonly array $allowedAttributesName,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        $providedAttributes = $candidate->attributes->records;
        foreach ($providedAttributes as $providedAttribute) {
            if (! in_array($providedAttribute->name, $this->allowedAttributesName)) {
                return Result::makeFailure(new InvalidArgumentException(sprintf(
                    'attribute "%s" is not allowed.',
                    $providedAttribute->name
                )));
            }
        }

        return Result::makeSuccess();
    }
}
