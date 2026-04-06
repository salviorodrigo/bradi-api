<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use Exception;
use InvalidArgumentException;

class Source
{
    public readonly string $value; // ClassName::MethodName

    public function __construct(string $data)
    {
        $validationException = $this->validate($data);
        if ($validationException !== null) {
            throw $validationException;
        }

        $this->value = $data;
    }

    public static function from(string $source): self
    {
        return new self($source);
    }

    public function validate(string $data): ?Exception
    {
        if (! $this->validateStructure($data)) {
            return new InvalidArgumentException("Invalid structure ({$data})");
        }

        [$className, $methodName] = explode('::', $data, 2);

        if (! class_exists($className, false)) {
            return new InvalidArgumentException("Class does not exist ({$className})");
        }

        if (! method_exists($className, $methodName)) {
            return new InvalidArgumentException("Method does not exist ({$className}::{$methodName})");
        }

        return null;
    }

    private function validateStructure(string $data): bool
    {
        return (bool) preg_match('/^[a-z_]\w*(\\\\[a-z_]\w*)*::[a-z_]\w*$/i', $data);
    }
}
