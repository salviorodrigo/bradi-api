<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Specifications;

use BradiApi\Domain\Common\Protocols\Specification;
use BradiApi\Domain\Common\Traits\SpecificationComposer;

final class EqualsSpecification implements Specification
{
    use SpecificationComposer;

    public function __construct(
        private readonly mixed $expectedValue
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $candidate === $this->expectedValue;
    }
}
