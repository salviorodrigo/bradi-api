<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\ValueObjects;

use BradiNfeApi\Common\Protocols\ApiError;
use Error;
use Exception;

class Result
{
    private function __construct(
        private readonly bool $success,
        private readonly mixed $data = null,
        private readonly ?ApiError $error = null
    ) {}

    public static function makeSuccess(mixed $value = null): self
    {
        if (
            is_a($value, ApiError::class) ||
            is_a($value, Exception::class) ||
            is_a($value, Error::class)
        ) {
            throw new Exception('This method doesn\'t accept Error\'s.');
        }

        if (empty((array) $value)) {
            $value = null;
        }

        return new self(true, $value);
    }

    public static function makeFailure(ApiError $error): self
    {
        return new self(false, null, $error);
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function isFailure(): bool
    {
        return ! $this->success;
    }

    public function getData(): mixed
    {
        if (! $this->isSuccess()) {
            throw new Exception('Result is an error.');
        }

        return $this->data;
    }

    public function hasValue(): bool
    {
        if (! $this->isSuccess()) {
            throw new Exception('Result is an error.');
        }

        return ! empty($this->data);
    }

    public function getError(): ApiError
    {
        if ($this->isSuccess()) {
            throw new Exception('Result is not an error.');
        }

        return $this->error;
    }
}
