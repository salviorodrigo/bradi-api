<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use InvalidArgumentException;
use OverflowException;

class Detail
{
    public readonly string $field;

    public array $errors;

    public function __construct(string $field, Error $error)
    {
        $this->field = (new FieldURI($field))->value;
        $this->errors[] = $error;
    }

    public function merge(Detail $detail): void
    {
        if ($this->field !== $detail->field) {
            throw new InvalidArgumentException("Cannot merge error details with different fields ('{$this->field}' and '{$detail->field}').");
        }

        foreach ($detail->errors as $error) {
            foreach ($this->errors as $existingError) {
                if ($existingError->source === $error->source && in_array($error->messages, $existingError->messages)) {
                    throw new OverflowException("Error '{$error->message}' ('{$error->source}') already exists in field '{$this->field}'.");
                }
            }

            $errorIndex = $this->getErrorIndexBySource($error->source);
            $this->errors[$errorIndex]->merge($error);
        }
    }

    protected function getErrorIndexBySource(string $source): int
    {
        foreach ($this->errors as $index => $error) {
            if ($error->source === $source) {
                return $index;
            }
        }
        throw new InvalidArgumentException("Error with source '{$source}' not found in field '{$this->field}'.");
    }

    protected function alreadyExistsErrorWithSource(string $source): bool
    {
        foreach ($this->errors as $error) {
            if ($error->source === $source) {
                return true;
            }
        }

        return false;
    }
}

// TODO Make test file.

/**
 * [
 * {
 *   "field": "xmlString.nfeProc.NFe",
 *   "erros": [
 *       {
 *           "source": // "ClassName::methodName"
 *           "input": "(string) 'abc'",
 *           "message": [
 *               "must be a positive number."
 *           ]
 *       }
 *   ]
 * },
 * ]
**/
