<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;

final class InvalidIndOrigemError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'it must be one of 0, 1, 2, 3, 4, 5, 6, 7 or 8.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
