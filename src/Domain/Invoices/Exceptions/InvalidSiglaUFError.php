<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Exceptions;

use BradiApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiApi\Domain\Common\ValueObjects\Detail;
use BradiApi\Domain\Common\ValueObjects\Error;
use BradiApi\Domain\Common\ValueObjects\Input;

final class InvalidSiglaUFError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'it must be a valid brazilian federative state acronym - Section 8.1.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
