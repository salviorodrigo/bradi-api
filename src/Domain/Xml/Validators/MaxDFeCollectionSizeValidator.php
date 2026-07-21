<?php

declare(strict_types=1);

namespace BradiApi\Domain\Xml\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

class MaxDFeCollectionSizeValidator implements Validator
{
    public function __construct(private readonly int $maxSize) {}

    public function check(mixed $candidate): Result
    {
        if (! is_array($candidate) && ! is_object($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('Candidate must be an array or an object.'));
        }

        foreach ($candidate as $item) {
            if (! (is_a($item, Element::class, true))) {
                return Result::makeFailure(new InvalidArgumentException('All items in the collection must be an Element.'));
            }
        }

        $collectionSize = count($candidate);
        if ($collectionSize > $this->maxSize) {
            return Result::makeFailure(new InvalidArgumentException("Collection size exceeds maximum of {$this->maxSize}. {$collectionSize} items given."));
        }

        return Result::makeSuccess();
    }
}
