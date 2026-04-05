<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

interface Specification
{
    public function isSatisfiedBy(mixed $candidate): bool;
}
