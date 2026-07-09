<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Templates;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\ValidationService as ValidationServiceProtocol;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Validators\RequiredAttributeValidator;
use BradiNfeApi\Domain\Invoices\Validators\RootTagValidator;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use RuntimeException;

abstract class DFeAttribute
{
    public const string FIELD_NAME = '';

    public string $value;

    public readonly string $parentTagName;
    public readonly string $fieldURI;

    private ValidationServiceProtocol $validationService;

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
        $this->validationService = new ValidationService($this->fieldURI, __METHOD__);

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
            fn ($candidate) => $this->validateParentTag($candidate),
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

    final protected function validateParentTag(Attribute $attribute): Result
    {
        $candidate = new Element;
        $candidate->name = $attribute->parentTagName;
        $candidate->addAttribute($attribute);
        $service = new ValidationService($this->fieldURI, __METHOD__);
        $service->addValidator(new RootTagValidator($this->parentTagName));

        return $service->verify($candidate);
    }

    /** @return Result<null|ApiError> */
    final protected function validateAttributeKey(Attribute $attribute): Result
    {
        $candidate = new Element;
        $candidate->name = $this->parentTagName;
        $candidate->addAttribute($attribute);
        $service = new ValidationService($this->fieldURI, __METHOD__);
        $service->addValidator(new RequiredAttributeValidator([static::FIELD_NAME]));

        return $service->verify($candidate);
    }

    /** @return Result<null|ApiError> */
    final protected function validateAttributeValue(Attribute $attribute): Result
    {
        $candidate = $attribute->value;
        $service = new ValidationService($this->fieldURI, __METHOD__);
        foreach ($this->attributeValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
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
