<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoSituacaoTributaria;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidCodigoSituacaoTributariaError;

final class IsTipoSituacaoTributariaValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoSituacaoTributaria::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidCodigoSituacaoTributariaError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
