<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Traits;

use BradiApi\Domain\Common\Protocols\Specification;
use BradiApi\Domain\Common\Specifications\AndSpecification;
use BradiApi\Domain\Common\Specifications\NotSpecification;
use BradiApi\Domain\Common\Specifications\OrSpecification;

trait SpecificationComposer
{
    public function and(Specification $other): Specification
    {
        return new AndSpecification($this, $other);
    }

    public function or(Specification $other): Specification
    {
        return new OrSpecification($this, $other);
    }

    public function not(): Specification
    {
        return new NotSpecification($this);
    }
}
