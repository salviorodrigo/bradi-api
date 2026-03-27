<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;

final class TooLongStringError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, int $maxLength)
    {
        $message = 'string length should not be greater than ' . $maxLength . '.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
