<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Services;

use BradiNfeApi\Common\Protocols\ApiError;
use BradiNfeApi\Common\Protocols\Validator;
use BradiNfeApi\Common\ValueObjects\Result;
use InvalidArgumentException;

class ValidationService
{
    /**
     * @param  $validators  array<Validator>
     */
    protected array $validators;

    /**
     * @param  array<Validator::class,array<mixed>>  $specifications
     */
    public function __construct(
        array $specifications,
        string $fieldURI,
        string $method,
        protected readonly bool $isOptional = false,
        protected readonly bool $stopOnFirstFailure = false)
    {
        if (count($specifications) <= 0) {
            throw new InvalidArgumentException('Validators must be provided.');
        }

        foreach ($specifications as $validator => $params) {
            if (! is_a($validator, Validator::class, true)) {
                throw new InvalidArgumentException('validators must be instances of Validator class.');
            }

            $this->validators[] = new $validator($fieldURI, $method, ...$params);
        }
    }

    public function verify(mixed $candidate): Result
    {
        if ($this->isOptional && (is_null($candidate) || $candidate === '')) {
            if (! isset($candidate)) {
                return Result::makeSuccess();
            }

            if (empty($candidate) && ! (is_bool($candidate) || $candidate == 0)) {
                return Result::makeSuccess();
            }
        }

        $validationErrorBag = [];
        foreach ($this->validators as $validator) {
            $validatorResponse = $validator->validate($candidate);
            if ($validatorResponse->isFailure()) {
                array_push($validationErrorBag, $validatorResponse->getError());
                if ($this->stopOnFirstFailure) {
                    break;
                }
            }
        }

        if (count($validationErrorBag) > 0) {
            return Result::makeFailure($this->mergeValidationErrors($validationErrorBag));
        }

        return Result::makeSuccess();
    }

    protected function mergeValidationErrors(array $validationErrorBag): ApiError
    {
        $mergedError = array_shift($validationErrorBag);
        foreach ($validationErrorBag as $validationError) {
            $mergedError->merge($validationError);
        }

        return $mergedError;
    }
}

// TODO Make test file.
