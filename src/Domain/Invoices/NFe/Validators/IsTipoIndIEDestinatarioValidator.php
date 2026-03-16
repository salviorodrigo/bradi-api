<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoIndIEDestinatario;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidTipoIndIEDestinatarioError;

final class IsTipoIndIEDestinatarioValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoIndIEDestinatario::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoIndIEDestinatarioError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
