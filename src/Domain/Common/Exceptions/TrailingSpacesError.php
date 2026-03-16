<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;

final class TrailingSpacesError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'trailing spaces is not allowed.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
