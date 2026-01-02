<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Validators\Exceptions\NotFoundAtLeastOneTagError;

final class AtLeastOneTagValidator extends Validator
{
    public function __construct(public readonly string $fieldName, public readonly array $tags) {}

    public function validate(mixed $candidate): Result
    {
        foreach ($this->tags as $tag) {
            if (DFeElement::xmlParser()->getTag($candidate, $tag) != '') {
                return Result::makeSuccess();
            }
        }

        return Result::makeFailure(new NotFoundAtLeastOneTagError($this->fieldName, $this->tags));
    }
}
