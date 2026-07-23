<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use InvalidArgumentException;

final class AttributeKeyValidator implements Validator
{
    public function __construct(
        public readonly string $attributeKey,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Attribute) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Attribute instance.'));
        }

        if (! isset($candidate->name)) {
            return Result::makeFailure(new InvalidArgumentException(sprintf('Key attribute "%s" expected.', $this->attributeKey)));
        }

        if ($candidate->name !== $this->attributeKey) {
            return Result::makeFailure(new InvalidArgumentException(sprintf('Key attribute "%s" expected. "%s" found.', $this->attributeKey, $candidate->name)));
        }

        return Result::makeSuccess();
    }
}
