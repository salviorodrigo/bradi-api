<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
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
    public const string ATTRIBUTE_NAME = '';

    public string $value;

    public readonly string $parentTagName;
    public readonly string $fieldURI;

    private ?Attribute $sourceAttribute;

    final public function __construct(string $parentFieldURI)
    {
        if ($parentFieldURI === '') {
            throw new RuntimeException(sprintf(
                'Parent field URI must be provided for attribute "%s".',
                static::ATTRIBUTE_NAME
            ));
        }

        $parents = explode('.', $parentFieldURI);
        $this->parentTagName = array_pop($parents);
        $this->fieldURI = $parentFieldURI . '.' . static::ATTRIBUTE_NAME;
    }

    /**
     * @return Result<DFeAttribute|ApiError>
     */
    final public function parseFromXmlElement(Element $element): Result
    {
        $validationSteps = [
            fn ($candidate) => $this->validateRootTag($candidate),
            fn ($candidate) => $this->validateTagAttributes($candidate),
            fn ($candidate) => $this->validateAttributeValue($candidate),
        ];

        foreach ($validationSteps as $validationService) {
            $validationResult = $validationService($element);
            if ($validationResult->isFailure()) {
                return $validationResult;
            }
        }

        $hydrateResult = $this->hydrateFromXmlElement($element);
        if ($hydrateResult->isFailure()) {
            return $hydrateResult;
        }

        return Result::makeSuccess($this);
    }

    /** @return array<Validator> */
    abstract protected function attributeValueValidators(): array;

    /** @return Result<null|ApiError> */
    final protected function validateRootTag(Element $element): Result
    {
        $service = new ValidationService($this->fieldURI, __METHOD__);
        $service->addValidator(new RootTagValidator($this->parentTagName));

        return $service->verify($element);
    }

    /** @return Result<null|ApiError> */
    final protected function validateTagAttributes(Element $element): Result
    {
        $service = new ValidationService($this->fieldURI, __METHOD__);
        $service->addValidator(new RequiredAttributeValidator([static::ATTRIBUTE_NAME]));

        return $service->verify($element);
    }

    /** @return Result<null|ApiError> */
    final protected function validateAttributeValue(Element $element): Result
    {
        $attribute = $element->attributes->{static::ATTRIBUTE_NAME};
        $candidate = $attribute->value;
        $service = new ValidationService($this->fieldURI, __METHOD__);
        foreach ($this->attributeValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /** @return Result<null|ApiError> **/
    private function hydrateFromXmlElement(Element $xmlElement): Result
    {
        $this->sourceAttribute = $xmlElement->attributes->{static::ATTRIBUTE_NAME};
        $this->value = $this->sourceAttribute->value;

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
        $this->sourceAttribute = new Attribute(static::ATTRIBUTE_NAME, $escapedValue);

        return (string) $this->sourceAttribute;
    }
}
