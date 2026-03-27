<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use InvalidArgumentException;
use OverflowException;

class Error
{
    public array $messages;

    public readonly string $input;
    public readonly string $source;

    public function __construct(string $source, string $input, string $message)
    {
        if (empty($message)) {
            throw new InvalidArgumentException('message cannot be empty.');
        }

        $this->input = (new Input($input))->value;
        $this->source = (new Source($source))->value;
        $this->messages[] = $message;
    }

    public function merge(Error $error): void
    {
        if ($this->source !== $error->source) {
            throw new InvalidArgumentException(
                "Cannot merge errors with different source ('{$this->source}' and '{$error->source}')."
            );
        }

        if ($this->input !== $error->input) {
            throw new InvalidArgumentException(
                "Cannot merge errors with same source but, different inputs ('{$this->input}' and '{$error->input}')."
            );
        }

        foreach ($error->messages as $messageItem) {
            if (in_array($messageItem, $this->messages)) {
                throw new OverflowException("Message '{$messageItem}' already exists in source '{$this->source}', for input '{$this->input}'.");
            }

            $this->messages[] = $messageItem;
        }
    }
}

// TODO Make test file.

/**
 * {
 *     // "ClassName::methodName"
 *     "input": "(number) -5",
 *     "message": [
 *         "must be a positive number."
 *     ]
 * }
 */
