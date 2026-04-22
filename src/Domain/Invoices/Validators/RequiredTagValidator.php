<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class RequiredTagValidator implements Validator
{
    public function __construct(
        public readonly array $requiredTagsName,
    ) {}

    public function check(mixed $candidate): Result
    {
        $providedTagsName = is_array($candidate) ? array_keys($candidate) : [];
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
