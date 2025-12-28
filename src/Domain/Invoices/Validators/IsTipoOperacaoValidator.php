<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\TipoOperacao;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidIdDestinoError;

final class IsTipoOperacaoValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoOperacao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidIdDestinoError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
