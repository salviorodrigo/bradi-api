<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Specifications;

use BradiNfeApi\Domain\Common\Protocols\Specification;
use BradiNfeApi\Domain\Common\Traits\SpecificationComposer;

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
