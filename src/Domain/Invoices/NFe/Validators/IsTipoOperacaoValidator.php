<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoOperacao;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidIdDestinoError;

final class IsTipoOperacaoValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoOperacao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidIdDestinoError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
