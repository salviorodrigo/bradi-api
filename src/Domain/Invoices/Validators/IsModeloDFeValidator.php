<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Validators;

use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Enums\ModeloDFe;
use InvalidArgumentException;

final class IsModeloDFeValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if (! (bool) ModeloDFe::tryFrom($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('must be a valid mod according MOC NFe e NFCe (7.0) - Anexo I..'));
        }

        return Result::makeSuccess();
    }
}

// TODO Make test file.
