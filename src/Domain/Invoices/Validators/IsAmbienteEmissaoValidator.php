<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\AmbienteEmissao;
use BradiNfeApi\Domain\Invoices\Exceptions\InvalidTipoAmbienteError;

final class IsAmbienteEmissaoValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) AmbienteEmissao::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoAmbienteError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
