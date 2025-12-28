<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Invoices\Enums\TipoMovimentacao;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidTipoNFError;

final class IsTipoMovimentacaoValidator extends Validator
{
    public function __construct(public readonly string $fieldName) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoMovimentacao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoNFError($this->fieldName));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
