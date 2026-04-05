<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Specifications;

use BradiNfeApi\Domain\Common\Protocols\Specification;
use BradiNfeApi\Domain\Common\Traits\SpecificationComposer;

final class AndSpecification implements Specification
{
    use SpecificationComposer;

    public function __construct(
        private Specification $previousSpec,
        private Specification $nextSpec
    ) {}

    public function isSatisfiedBy(mixed $candidate): bool
    {
        return $this->previousSpec->isSatisfiedBy($candidate)
        |> (fn ($result) => $result && $this->nextSpec->isSatisfiedBy($candidate));
    }
}
