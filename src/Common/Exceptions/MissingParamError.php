<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Exceptions;

use BradiNfeApi\Common\Protocols\BadRequestError;
use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;

final class MissingParamError extends BadRequestError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'cannot be null.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
