<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Validators;

use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use InvalidArgumentException;

final class NotNullValidator implements Validator
{
    public function check(mixed $candidate): Result
    {
        if ($this->isEmpty($candidate)) {
            return Result::makeFailure(new InvalidArgumentException('cannot be null.'));
        }

        return Result::makeSuccess();
    }

    /**
     * O despacho era montado por `gettype()` (`isEmpty` . `Integer`/`Boolean`/...),
     * entao qualquer escalar batia em metodo inexistente e lancava `Error` em vez
     * de devolver `Result`. Aqui null era barrado antes pelo curto-circuito do
     * `||`, mas os escalares nao. Escalar preenchido nao e vazio: `'0'` ja era
     * aceito como valor valido, e `0`, `0.0` e `false` seguem a mesma regra.
     */
    private function isEmpty(mixed $candidate): bool
    {
        return match (true) {
            is_null($candidate) => true,
            is_string($candidate) => $this->isEmptyString($candidate),
            is_array($candidate) => $this->isEmptyArray($candidate),
            is_object($candidate) => $this->isEmptyObject($candidate),
            default => false,
        };
    }

    private function isEmptyString(string $candidate): bool
    {
        $candidate = trim($candidate);

        return $candidate === '' || $candidate === 'null';
    }

    private function isEmptyArray(array $candidate): bool
    {
        return count($candidate) === 0;
    }

    private function isEmptyObject(object $candidate): bool
    {
        return count(get_object_vars($candidate)) === 0;
    }
}
