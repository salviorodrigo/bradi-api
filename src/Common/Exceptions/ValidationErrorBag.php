<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Exceptions;

use InvalidArgumentException;

class ValidationErrorBag
{
    public array $validationErrors = [];

    public function __construct() {}

    public function add(ValidationError $validationError)
    {

        $this->validationErrors[] = $validationError;
    }

    public function resolve(): ValidationError
    {
        if (count($this->validationErrors) <= 0) {
            throw new InvalidArgumentException('ValidationsErrors must be provided.');
        }
        for ($pointer = 1; $pointer < count($this->validationErrors); $pointer++) {
            $this->validationErrors[0]->details['message'] = [...$this->validationErrors[0]->details['message'], ...$this->validationErrors[$pointer]->details['message']];
        }

        return $this->validationErrors[0];
    }
}

// TODO Make test file.
