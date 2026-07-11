<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Protocols;

use BradiApi\Domain\Common\ValueObjects\Result;
use Exception;

interface Validator
{
    /** @return Result<null|Exception> */
    public function check(mixed $candidate): Result;
}
