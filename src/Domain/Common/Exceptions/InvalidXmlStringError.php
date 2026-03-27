<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;

final class InvalidXmlStringError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'must be a valid xml string.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
