<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;

final class InvalidDecimalNumberError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, int $maxIntegerDigits, int $maxDecimalDigits)
    {
        $message = "should be a decimal number with up to {$maxIntegerDigits} integer digits and {$maxDecimalDigits} decimal digits, separated by dot.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }
}
