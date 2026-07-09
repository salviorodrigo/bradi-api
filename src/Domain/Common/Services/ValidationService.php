<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Services;

use BradiNfeApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\Protocols\ValidationService as ValidationServiceProtocol;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\FieldURI;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\ValueObjects\Source;
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
