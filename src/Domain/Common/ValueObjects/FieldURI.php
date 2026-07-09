<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use Exception;
use InvalidArgumentException;

class FieldURI
{
    public readonly string $value;

    public function __construct(string $data)
    {
        $validationException = $this->validate($data);
        if ($validationException !== null) {
            throw $validationException;
        }

        $this->value = $data;
    }

    public static function from(string $fieldURI): self
    {
        return new self($fieldURI);
    }

    private function validate(string $data): ?Exception
    {
        if (! $this->validateStructure($data)) {
            return new InvalidArgumentException("Invalid structure ({$data})");
        }

        foreach (explode('.', $data) as $segment) {
            if (! $this->validateSegment($segment)) {
                return new InvalidArgumentException("Invalid segment ({$segment})");
            }
        }

        return null;
    }

    private function validateStructure(string $data): bool
    {
        return (bool) preg_match('/^[\w\s\[\]]+(\.[\w\s\[\]]+)*$/', $data);
    }

    private function validateSegment(string $segment): bool
    {
        if ($this->hasArrayNotation($segment)) {
            return (bool) preg_match('/^[a-zA-Z_]\w*(\[(\d+|([\'\"])\w+\3)\])+$/', $segment);
        }

        return (bool) preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $segment);
    }

    private function hasArrayNotation(string $segment): bool
    {
        return strpos($segment, '[') !== false || strpos($segment, ']') !== false;
    }
}

/**
 * Allows
 *
 *  Nome
 *  Nome[0]
 *  Nome['key string']
 *  Nome['key string'][0]
 *  Nome.OutroNome
 *  Nome.OutroNome.[...].UltimoNome
 */
