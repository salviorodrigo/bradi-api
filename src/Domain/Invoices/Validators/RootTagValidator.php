<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class RootTagValidator implements Validator
{
    public function __construct(
        public readonly string $rootTagName,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        if (! isset($candidate->name)) {
            return Result::makeFailure(new InvalidArgumentException(sprintf('Tag "%s" expected.', $this->rootTagName)));
        }

        if ($candidate->name !== $this->rootTagName) {
            return Result::makeFailure(new InvalidArgumentException(sprintf('Tag "%s" expected. "%s" found.', $this->rootTagName, $candidate->name)));
        }
            
        return Result::makeSuccess();
    }
}
