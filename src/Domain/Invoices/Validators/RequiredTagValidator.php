<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class RequiredTagValidator implements Validator
{
    public function __construct(
        public readonly array $requiredTagsName,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        $providedTagsName = array_map(
            fn (Element $element) => $element->name,
            $candidate->children->records,
        );
        foreach ($this->requiredTagsName as $requiredTag) {
            if (! in_array($requiredTag, $providedTagsName)) {
                return Result::makeFailure(new InvalidArgumentException(sprintf(
                    'tag "%s" must be informed.',
                    $requiredTag
                )));
            }
        }

        return Result::makeSuccess();
    }
}
