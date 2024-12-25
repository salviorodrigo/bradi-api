<?php

declare(strict_types=1);

namespace BradiNfeApi\Common;

use BradiNfeApi\Common\Exceptions\GenericApiError;
use Error;
use Exception;

class Result
{
    private bool $success;
    private mixed $data;
    private Exception $error;

    private function __construct(bool $success, mixed $data = null, Exception $error = new GenericApiError)
    {
        $this->success = $success;
        $this->data = $data;
        $this->error = $error;
    }

    public static function makeSuccess(mixed $value = null): self
    {
        if (is_a($value, Exception::class) || is_a($value, Error::class)) {
            throw new Exception('This method doesn\'t accept Error\'s.');
        }

        return new self(true, $value);
    }

    public static function makeFailure(Exception $error): self
    {
        return new self(false, null, $error);
    }

    public function isSuccess(): bool
    {
        return $this->success;
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

    public function getError(): Exception
    {
        if ($this->isSuccess()) {
            throw new Exception('Result is not an error.');
        }

        return $this->error;
    }
}
