<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;

final class RequiredAttributeValidator implements Validator
{
    public function __construct(
        public readonly array $requiredAttributesName,
    ) {}

    public function check(mixed $candidate): Result
    {
        if (! $candidate instanceof Element) {
            return Result::makeFailure(new InvalidArgumentException('candidate must be an Element instance.'));
        }

        $providedAttributesName = array_map(
            fn (Attribute $attribute) => $attribute->name,
            $candidate->attributes->records,
        );
        foreach ($this->requiredAttributesName as $requiredAttribute) {
            if (! in_array($requiredAttribute, $providedAttributesName)) {
                return Result::makeFailure(new InvalidArgumentException(sprintf(
                    'attribute "%s" must be informed.',
                    $requiredAttribute
                )));
            }
        }

        return Result::makeSuccess();
    }
}
