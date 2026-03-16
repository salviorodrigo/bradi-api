<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\LessThanError;

final class MinValueValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly float $minValue
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator($this->fieldURI, $this->source, true);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure() || (float) $candidate < $this->minValue) {
            return Result::makeFailure(new LessThanError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->minValue
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
