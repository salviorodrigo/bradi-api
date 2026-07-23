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
    public const string FIELD_NAME = '';

    public string $value;

    public readonly string $parentTagName;
    public readonly string $fieldURI;

    private ValidationService $validationService;

    private ?Attribute $sourceAttribute;

    final public function __construct(string $parentFieldURI)
    {
        if ($parentFieldURI === '') {
            throw new RuntimeException(sprintf(
                'Parent field URI must be provided for attribute "%s".',
                static::FIELD_NAME
            ));
        }

        $parents = explode('.', $parentFieldURI);
        $this->parentTagName = array_pop($parents);
        $this->fieldURI = $parentFieldURI . '.' . static::FIELD_NAME;
        $this->validationService = new ValidationService($this->fieldURI);

        if (! defined(static::class . '::FIELD_NAME') || static::FIELD_NAME === '') {
            throw new RuntimeException(sprintf(
                'The class "%s" must define a constant "FIELD_NAME" with the name of the XML attribute it represents.',
                static::class
            ));
        }
    }

    /**
     * @return Result<DFeAttribute|ApiError>
     */
    final public function parseFromXmlElement(Attribute $attribute): Result
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

        $hydrateResult = $this->hydrateFromXmlElement($attribute);
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
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

    /** @return Result<null|ApiError> **/
    private function hydrateFromXmlElement(Attribute $attribute): Result
    {
        $this->sourceAttribute = $attribute;
        $this->value = $attribute->value;

        return Result::makeSuccess();
    }

    final public function __toString(): string
    {
        if (isset($this->sourceAttribute)) {
            return (string) $this->sourceAttribute;
        }

        if (! isset($this->value)) {
            throw new RuntimeException(sprintf(
                'Property "%s::$value" must be initialized before serialization.',
                static::class
            ));
        }

        $escapedValue = htmlspecialchars($this->value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $this->sourceAttribute = new Attribute(static::FIELD_NAME, $escapedValue, $this->parentTagName);

        return (string) $this->sourceAttribute;
    }
}
