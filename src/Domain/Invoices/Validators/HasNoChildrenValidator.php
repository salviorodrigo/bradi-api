<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;
use UnexpectedValueException;

final class HasNoChildrenValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        if (count($candidate->children->records) > 0) {
            return Result::makeFailure(new UnexpectedValueException('cannot contain child elements.'));
        }

        return Result::makeSuccess();
    }
}
