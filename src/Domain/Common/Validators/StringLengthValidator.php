<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use LengthException;

final class StringLengthValidator implements Validator
{
    private array $stringLengths;

    public function __construct(
        int ...$stringLengths
    ) {
        foreach ($stringLengths as $stringLength) {
            $this->stringLengths[] = $stringLength;
        }
    }

    public function check(mixed $candidate): Result
    {
        $typeValidator = new IsStringValidator;
        $typeValidationResult = $typeValidator->check($candidate);
        if ($typeValidationResult->isFailure()) {
            return Result::makeFailure(new LengthException($this->buildMessage()));
        }

        if (! array_find($this->stringLengths, fn ($stringLength) => strlen($candidate) === $stringLength)) {
            return Result::makeFailure(new LengthException($this->buildMessage()));
        }

        return Result::makeSuccess();
    }

    private function buildMessage(): string
    {
        if (count($this->stringLengths) === 1) {
            return sprintf('must contain exactly %d characters.', $this->stringLengths[0]);
        }

        return sprintf(
            'must contain one of the following lengths: %s.',
            implode(', ', $this->stringLengths)
        );
    }
}
