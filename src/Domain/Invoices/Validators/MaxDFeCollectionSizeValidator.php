<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use InvalidArgumentException;

class MaxDFeCollectionSizeValidator implements Validator
{
    public function __construct(private readonly int $maxSize) {}

    public function check(mixed $candidate): Result
    {
        if (! is_a($candidate, DFeElementCollection::class, true)) {
            return Result::makeFailure(new InvalidArgumentException('Candidate must be a DFeElementCollection'));
        }

        $collectionSize = count($candidate->collection);
        if ($collectionSize > $this->maxSize) {
            return Result::makeFailure(new InvalidArgumentException("Collection size exceeds maximum of {$this->maxSize}. {$collectionSize} items given."));
        }

        return Result::makeSuccess();
    }
}
