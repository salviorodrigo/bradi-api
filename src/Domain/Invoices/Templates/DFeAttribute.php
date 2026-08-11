<?php

declare(strict_types=1);

namespace BradiApi\Domain\Invoices\Templates;

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AttributeKeyValidator;
use BradiApi\Domain\Xml\ValueObjects\Attribute;
use RuntimeException;

abstract class DFeAttribute
{
    public const ?string FIELD_NAME = null;

    public ?string $value = null;

    public readonly string $fieldURI;

    private ValidationService $validationService;
    private ?Attribute $source;

    final public function __construct(string $parentFieldURI)
    {
        if (empty(static::FIELD_NAME)) {
            throw new RuntimeException(sprintf(
                'The class "%s" must define a constant "FIELD_NAME" with the name of the XML attribute it represents.',
                static::class
            ));
        }

        if ($parentFieldURI === '') {
            throw new RuntimeException(sprintf(
                'Parent field URI must be provided for attribute "%s".',
                static::FIELD_NAME
            ));
        }

        $this->fieldURI = $parentFieldURI . '.' . static::FIELD_NAME;
        $this->validationService = new ValidationService($this->fieldURI);
    }

    /** @return Result<DFeAttribute|ApiError> */
    final public function parse(Attribute $attribute): Result
    {
        $validationSteps = [
            fn ($candidate) => $this->validateAttributeKey($candidate),
            fn ($candidate) => $this->validateAttributeValue($candidate),
        ];

        foreach ($validationSteps as $validationService) {
            $validationResult = $validationService($attribute);
            if ($validationResult->isFailure()) {
                return $validationResult;
            }
        }

        $hydrateResult = $this->hydrate($attribute);
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
    }

    final public function toXML(): ?Attribute
    {
        $this->sync();

        return $this->source;
    }

    final public function toString(): string
    {
        $this->sync();

        return (string) $this->source;
    }

    /** @return array<Validator> */
    abstract protected function attributeValueValidators(): array;

    /** @return Result<null|ApiError> */
    final protected function validateAttributeKey(Attribute $attribute): Result
    {
        $this->validationService->reset();
        $this->validationService->addValidator(new AttributeKeyValidator(static::FIELD_NAME));

        return $this->validationService->verify($attribute);
    }

    /** @return Result<null|ApiError> */
    final protected function validateAttributeValue(Attribute $attribute): Result
    {
        $candidate = $attribute->value;
        $this->validationService->reset();
        foreach ($this->attributeValueValidators() as $validator) {
            $this->validationService->addValidator($validator);
        }

        return $this->validationService->verify($candidate);
    }

    private function initSource(): void
    {
        $this->source = new Attribute(static::FIELD_NAME, $this->value);
    }

    /** @return Result<null|ApiError> **/
    private function hydrate(Attribute $attribute): Result
    {
        $this->source = $attribute;
        $this->value = $attribute->value;

        return Result::makeSuccess();
    }

    private function sync(): void
    {
        if (! isset($this->value) || $this->value === '') {
            $this->source = null;

            return;
        }

        if (! isset($this->source)) {
            $this->initSource();

            return;
        }

        if ($this->source->value !== $this->value) {
            $this->source->value = $this->value;
        }
    }

    final public function __toString(): string
    {
        return $this->toString();
    }
}
