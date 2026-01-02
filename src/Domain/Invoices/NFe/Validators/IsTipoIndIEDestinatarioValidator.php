<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\TipoIndIEDestinatario;
use BradiNfeApi\Domain\Invoices\NFe\Validators\Exceptions\InvalidTipoIndIEDestinatarioError;

final class IsTipoIndIEDestinatarioValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoIndIEDestinatario::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoIndIEDestinatarioError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
