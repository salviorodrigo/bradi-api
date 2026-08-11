<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class TagsSequenceValidator implements Validator
{
    public function __construct(
        public readonly array $tagsNameOnSequence,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        if ($this->tagsNameOnSequence === []) {
            return Result::makeSuccess();
        }

        $positionByTagName = array_flip(array_values(array_unique($this->tagsNameOnSequence)));
        $previousTagName = null;
        $previousPosition = -1;
        foreach ($candidate->children->records as $child) {
            $position = $positionByTagName[$child->name] ?? null;
            if ($position === null) {
                continue;
            }

            if ($position < $previousPosition) {
                return Result::makeFailure(new InvalidArgumentException(sprintf(
                    'tag "%s" is out of sequence. It must be informed before "%s".',
                    $child->name,
                    $previousTagName
                )));
            }

            $previousTagName = $child->name;
            $previousPosition = $position;
        }

        return Result::makeSuccess();
    }
}
