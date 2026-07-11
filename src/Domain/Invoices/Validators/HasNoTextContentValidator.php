<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;
use UnexpectedValueException;

final class HasNoTextContentValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if ($candidate instanceof Element) {
            $textContent = $candidate->value ?? '';
        } elseif (is_string($candidate)) {
            $textContent = $candidate;
        } else {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance or string.'));
        }

        if ($textContent !== '') {
            return Result::makeFailure(new UnexpectedValueException('cannot contain text content.'));
        }

        return Result::makeSuccess();
    }
}
