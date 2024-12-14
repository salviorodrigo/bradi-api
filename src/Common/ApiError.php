<?php

declare(strict_types=1);

namespace BradiNfeApi\Common;

abstract class ApiError
{
    public string $status;
    public string $title;
    public array $details;
}
