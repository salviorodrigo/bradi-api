<?php

declare(strict_types=1);

namespace BradiNfeApi\Common;

use Exception;

abstract class ApiError extends Exception
{
    public string $httpStatus;
    public string $title;
    public array $details;
}
