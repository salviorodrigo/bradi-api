<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Exceptions;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\ValueObjects\Detail;

final class BadRequestError extends ApiError
{
    public string $type = 'https://httpstatuses.com/400';
    public string $status = '400';
    public string $title = 'Bad Request';
    public string $description = 'The request could not be understood by the server due to malformed syntax.';

    public function __construct(Detail $detail)
    {
        parent::__construct($detail);
    }
}
