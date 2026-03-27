<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\NFe\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\TipoEmissaoNF;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidTipoEmissaoNFError;

final class IsTipoEmissaoValidator extends Validator
{
    public function __construct(
        public readonly string $fieldURI,
        public readonly string $source
    ) {}

    public function validate(mixed $candidate): Result
    {
        if (! (bool) TipoEmissaoNF::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidTipoEmissaoNFError(
                $this->fieldURI,
                $this->source,
                $candidate
            ));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
