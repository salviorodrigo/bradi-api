<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Exceptions\NotFoundTagError;

final class RequiredTagValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source,
        public readonly array $requiredTagsName,
        public readonly array $providedTagsName
    ) {}

    public function validate(mixed $candidate): Result
    {
        foreach ($this->requiredTagsName as $requiredTag) {
            if (! in_array($requiredTag, $this->providedTagsName)) {
                return Result::makeFailure(new NotFoundTagError(
                    $this->fieldURI,
                    $this->source,
                    $candidate,
                    $requiredTag
                ));
            }
        }

        return Result::makeSuccess();
    }
}
