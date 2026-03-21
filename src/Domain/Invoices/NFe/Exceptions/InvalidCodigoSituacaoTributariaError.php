<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;

final class InvalidCodigoSituacaoTributariaError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input)
    {
        $message = 'it must be a valid CST according to the Brazilian tax regulations.';
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
