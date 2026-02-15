<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Common\Result;

interface HasValue
{
    public static function validateTagValue(string $tagValue): Result;
}
