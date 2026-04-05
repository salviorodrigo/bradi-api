<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Specifications;

use BradiNfeApi\Domain\Common\Protocols\Specification;
use BradiNfeApi\Domain\Common\Traits\SpecificationComposer;

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
