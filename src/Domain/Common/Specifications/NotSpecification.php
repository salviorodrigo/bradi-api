<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Specifications;

use BradiApi\Domain\Common\Protocols\Specification;
use BradiApi\Domain\Common\Traits\SpecificationComposer;

class NotSpecification implements Specification
{
    use SpecificationComposer;

    public function __construct(
        private Specification $specification
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return ! $this->specification->isSatisfiedBy($candidate);
    }
}
