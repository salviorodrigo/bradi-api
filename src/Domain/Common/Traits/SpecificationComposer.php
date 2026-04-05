<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Traits;

use BradiNfeApi\Domain\Common\Protocols\Specification;
use BradiNfeApi\Domain\Common\Specifications\AndSpecification;
use BradiNfeApi\Domain\Common\Specifications\NotSpecification;
use BradiNfeApi\Domain\Common\Specifications\OrSpecification;

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
