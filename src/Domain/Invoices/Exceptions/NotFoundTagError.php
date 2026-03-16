<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;

final class NotFoundTagError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, string $requiredTagName)
    {
        $message = "{$requiredTagName} xml tag is required.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
