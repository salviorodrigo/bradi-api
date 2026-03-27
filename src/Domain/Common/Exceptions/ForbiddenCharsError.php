<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use InvalidArgumentException;

final class ForbiddenCharsError extends UnprocessableEntityError
{
    /**
     * @param  array<string>  $forbiddenChars
     * */
    public function __construct(string $field, string $source, mixed $input, array $forbiddenChars)
    {
        foreach ($forbiddenChars as $forbiddenChar) {
            if (! is_string($forbiddenChar)) {
                throw new InvalidArgumentException('forbiddenChars array must contain only strings. ' . gettype($forbiddenChar) . ' given.');
            }
        }

        $forbiddenCharsString = $this->getForbiddenCharsString($forbiddenChars);
        $message = "following forbidden characters {$forbiddenCharsString} was given.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function getForbiddenCharsString(array $forbiddenChars): string
    {
        switch (count($forbiddenChars)) {
            case 0:
                throw new InvalidArgumentException('forbiddenChars array must have at least one element.');
            case 1:
                return $forbiddenChars[0];

            default:
                $lastForbiddenChar = array_pop($forbiddenChars);
                $allowedChildElementsNamesAsString = implode(', ', $forbiddenChars);

                return $allowedChildElementsNamesAsString . ' and ' . $lastForbiddenChar;
        }
    }
}
