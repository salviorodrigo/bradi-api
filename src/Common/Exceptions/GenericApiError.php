<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Exceptions;

use BradiNfeApi\Common\ApiError;

class GenericApiError extends ApiError
{
    public string $httpStatus = '418';
    public string $title = 'Generic Api Error';
    public array $details = ['message' => "I\'m a teapot 2"];
}
