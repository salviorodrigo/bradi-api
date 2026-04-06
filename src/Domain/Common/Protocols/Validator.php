<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use Exception;

interface Validator
{
    /** @return Result<null|Exception> */
    public function check(mixed $candidate): Result;
}
