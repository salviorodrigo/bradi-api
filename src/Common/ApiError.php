<?php

declare(strict_types=1);

namespace BradiNfeApi\Common;

use Exception;
use Throwable;

abstract class ApiError extends Exception
{
    public string $httpStatus;
    public string $title;
    public array $details;

    public function __construct(string $message = 'This is an ApiError', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
