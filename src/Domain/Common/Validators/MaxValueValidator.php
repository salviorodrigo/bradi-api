<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Exceptions\GreatThanError;

final class MaxValueValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly float $maxValue
    ) {}

    public function validate(mixed $candidate): Result
    {
        $typeValidator = new IsNumericValidator($this->fieldURI, $this->source, true);
        $typeValidationResult = $typeValidator->validate($candidate);
        if ($typeValidationResult->isFailure() || (float) $candidate > $this->maxValue) {
            return Result::makeFailure(new GreatThanError(
                $this->fieldURI,
                $this->source,
                $candidate,
                $this->maxValue
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
