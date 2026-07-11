<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Exceptions;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Detail;

final class UnprocessableEntityError extends ApiError
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
