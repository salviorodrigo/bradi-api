<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;

final class InvalidCNPJError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'this value must be a valid brazilian CNPJ value, with just numeric chars.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
