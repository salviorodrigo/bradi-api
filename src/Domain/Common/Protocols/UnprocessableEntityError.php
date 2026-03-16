<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Common\Protocols\ApiError;
use BradiNfeApi\Common\ValueObjects\Detail;

abstract class UnprocessableEntityError extends ApiError
{
    public string $type = 'https://httpstatuses.com/422';
    public string $status = '422';
    public string $title = 'Unprocessable Entity';
    public string $description = 'The request was well-formed but was unable to be followed due to data validation errors.';

    public function __construct(Detail $detail)
    {
        parent::__construct($detail);
    }
}
