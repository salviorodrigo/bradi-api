<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Exceptions;

use BradiNfeApi\Common\ApiError;
use BradiNfeApi\Domain\Common\Protocols\ValidatorError;
use InvalidArgumentException;

class ValidationError extends ApiError
{
    public string $httpStatus = '400';
    public string $title = 'Bad Request';
    public array $details = ['message' => []];

    public function __construct(array $validatorErrors)
    {
        if (count($validatorErrors) <= 0) {
            throw new InvalidArgumentException('ValidatorErrors must be provided.');
        }
        foreach ($validatorErrors as $validatorError) {
            if (! is_a($validatorError, ValidatorError::class)) {
                throw new InvalidArgumentException('Validation error just accepts Validator errors.');
            }
            if (! array_key_exists($validatorError->fieldName, $this->details['message'])) {
                $this->details['message'][$validatorError->fieldName] = [];
            }
            if (! in_array($validatorError->getMessage(), $this->details['message'][$validatorError->fieldName])) {
                $this->details['message'][$validatorError->fieldName] = [...$this->details['message'][$validatorError->fieldName], $validatorError->getMessage()];
            }
        }
        $message = 'A data validation error occurs.';
        parent::__construct($message, 400);
    }
}

// TODO Make test file.
