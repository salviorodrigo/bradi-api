<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Protocols;

interface Specification
{
    public function isSatisfiedBy(mixed $candidate): bool;
}
