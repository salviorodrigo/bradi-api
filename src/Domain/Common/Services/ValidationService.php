<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Services;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use InvalidArgumentException;

final class ValidationService
{
    private readonly array $validators;

    public function __construct(array $validators)
    {
        if (count($validators) <= 0) {
            throw new InvalidArgumentException('Validators must be provided.');
        }
        foreach ($validators as $validator) {
            if (! is_a($validator, Validator::class)) {
                throw new InvalidArgumentException('Concrete validators must implement IValidator interface.');
            }
        }
        $this->validators = $validators;
    }

    public function verify(mixed $candidate): Result
    {
        $validationErrorBag = [];
        foreach ($this->validators as $validator) {
            $validatorResponse = $validator->validate($candidate);
            if (! $validatorResponse->isSuccess()) {
                array_push($validationErrorBag, $validatorResponse->getError());
            }
        }
        if (count($validationErrorBag) > 0) {
            return Result::makeFailure(new ValidationError($validationErrorBag));
        }

        return Result::makeSuccess();
    }
}
