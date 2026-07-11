<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\Services;

use BradiApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiApi\Domain\Common\Protocols\ValidationService as ValidationServiceProtocol;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Detail;
use BradiApi\Domain\Common\ValueObjects\FieldURI;
use BradiApi\Domain\Common\ValueObjects\Input;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Common\ValueObjects\Source;
use Exception;

class ValidationService implements ValidationServiceProtocol
{
    /** @param array<Validator> $validators   */
    private array $validators = [];
    /** @var Exception[] */
    private array $errors = [];

    public function __construct(
        private readonly string $fieldURI,
        private readonly string $method
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
            $errorDetail = new Detail(
                FieldURI::from($this->fieldURI),
                Source::from($this->method),
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
    }
}
