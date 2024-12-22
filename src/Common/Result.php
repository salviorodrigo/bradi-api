<?php

declare(strict_types=1);

namespace BradiNfeApi\Common;

use BradiNfeApi\Common\Exceptions\GenericApiError;
use Exception;

class Result
{
    private bool $success;
    private mixed $data;
    private ApiError $error;

    private function __construct(bool $success, mixed $data = null, ApiError $error = new GenericApiError)
    {
        $this->success = $success;
        $this->data = $data;
        $this->error = $error;
    }

    public static function makeSuccess(mixed $value = null): self
    {
        if (is_a($value, Exception::class)) {
            throw new Exception('This method doesn\'t accept Exception\'s.');
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
