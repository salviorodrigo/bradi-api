<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Services;

use BradiApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Detail;
use BradiApi\Domain\Common\ValueObjects\FieldURI;
use BradiApi\Domain\Common\ValueObjects\Input;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Common\ValueObjects\Source;
use Exception;

class ValidationService
{
    /** @param array<Validator> $validators   */
    private array $validators = [];
    /** @var Exception[] */
    private array $errors = [];

    public function __construct(
        private readonly string $fieldURI
    ) {}

    public function verify(mixed $candidate): Result
    {
        foreach ($this->validators as $validator) {
            $validatorResponse = $validator->check($candidate);
            if ($validatorResponse->isFailure()) {
                $error = $validatorResponse->getError();
                if ($error instanceof Exception) {
                    $this->errors[] = $error;
                }
            }
        }

        if (! empty($this->errors)) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
            $method = "{$backtrace['class']}::{$backtrace['function']}";
            $errorDetail = new Detail(
                FieldURI::from($this->fieldURI),
                Source::from($method),
                Input::from($candidate),
                $this->errors
            );

            return Result::makeFailure(new UnprocessableEntityError($errorDetail));
        }

        return Result::makeSuccess();
    }

    public function addValidator(Validator $validator): self
    {
        $this->validators[] = $validator;

        return $this;
    }

    public function reset(): void
    {
        $this->validators = [];
        $this->errors = [];
    }
}
