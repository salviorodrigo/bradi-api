<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class AllowedTagsValidator implements Validator
{
    public function __construct(
        public readonly array $allowedTagsName,
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
        foreach ($providedTagsName as $providedTag) {
            if (! in_array($providedTag, $this->allowedTagsName)) {
                return Result::makeFailure(new InvalidArgumentException(sprintf(
                    'tag "%s" is not allowed.',
                    $providedTag
                )));
            }
        }

        return Result::makeSuccess();
    }
}
