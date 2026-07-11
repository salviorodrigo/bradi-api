<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Specifications;

use BradiApi\Domain\Common\Protocols\Specification;
use BradiApi\Domain\Common\Traits\SpecificationComposer;

class OrSpecification implements Specification
{
    use SpecificationComposer;

    public function __construct(
        private Specification $previousSpec,
        private Specification $nextSpec
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $this->previousSpec->isSatisfiedBy($candidate)
        |> (fn ($result) => $result || $this->nextSpec->isSatisfiedBy($candidate));
    }
}
