<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\TipoEmissaoNF;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidTipoEmissaoNFError;

final class IsTipoEmissaoValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoEmissaoNF::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoEmissaoNFError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
