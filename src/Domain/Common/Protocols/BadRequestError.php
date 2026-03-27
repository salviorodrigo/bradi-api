<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Domain\Common\ValueObjects\Detail;

abstract class BadRequestError extends ApiError
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
