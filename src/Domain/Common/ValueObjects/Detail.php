<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use Exception;
use InvalidArgumentException;

/**
 * {
 *   "field": "xmlString.nfeProc.NFe",
 *   "source": "ClassName::methodName"
 *   "input": "(string) 'abc'",
 *   "message": [
 *       "must be numeric.",
 *       "must be a positive number."
 *   ]
 * }
 **/
class Detail
{
    public readonly string $field;
    public readonly string $input;
    public readonly string $source;

    /** @var string[] */
    public array $messages = [];

    /** @param Exception[] $errors */
    public function __construct(FieldURI $field, Source $source, Input $input, array $errors)
    {
        $this->field = $field->value;
        $this->source = $source->value;
        $this->input = $input->value;
        foreach ($errors as $error) {
            if (! is_a($error, Exception::class)) {
                throw new InvalidArgumentException('Errors must be instances of Exception.');
            }

            $this->messages[] = $error->getMessage();
        }
    }

    public function merge(Detail $detail): self
    {
        if ($this->field !== $detail->field
            && $this->input !== $detail->input
            && $this->source !== $detail->source) {
            throw new InvalidArgumentException('Cannot merge error details with different field, input or source.');
        }

        foreach ($detail->messages as $message) {
            if (! in_array($message, $this->messages, true)) {
                $this->messages[] = $message;
            }
        }

        return $this;
    }
}
