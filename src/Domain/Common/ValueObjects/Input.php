<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use BradiNfeApi\Domain\Common\Enum\PrimitiveType;
use Exception;
use InvalidArgumentException;

class Input
{
    public readonly string $value; // "(typeString) jsonString"

    public function __construct(string $data)
    {
        $validationException = $this->validate($data);
        if ($validationException !== null) {
            throw $validationException;
        }

        $this->value = $data;
    }

    public static function from(mixed $data): self
    {
        $inputDataString = '(' . gettype($data) . ') ' . json_encode($data);

        return new self($inputDataString);
    }

    private function validate(string $data): ?Exception
    {
        if (! $this->validateStructure($data)) {
            return new InvalidArgumentException("Invalid structure ({$data})");
        }

        if (! $this->validateType($data)) {
            return new InvalidArgumentException("Invalid type ({$data})");
        }

        if (! $this->validateJson($data)) {
            return new InvalidArgumentException("Invalid JSON part ({$data})");
        }

        return null;
    }

    private function validateStructure(string $data): bool
    {
        return (bool) preg_match('/^\((\w+)\)\x20(.*)$/', $data);
    }

    private function validateType(string $data): bool
    {
        $typeString = $this->getTypePart($data);

        return PrimitiveType::tryFrom($typeString) !== null;
    }

    private function validateJson(string $data): bool
    {
        $jsonString = $this->getJsonPart($data);

        return json_validate($jsonString);
    }

    private function getTypePart(string $data): string
    {
        $typePart = explode(' ', $data, 2)[0];

        return trim($typePart, '()');
    }

    private function getJsonPart(string $data): string
    {
        return explode(' ', $data, 2)[1];
    }
}
