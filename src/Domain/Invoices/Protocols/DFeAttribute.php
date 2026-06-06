<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\FieldURI;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\ValueObjects\Source;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use InvalidArgumentException;
use RuntimeException;

abstract class DFeAttribute
{
    public const string ATTRIBUTE_NAME = '';

    public string $value;

    public readonly string $parentTagName;
    public readonly string $fieldURI;

    private ?Attribute $attribute;

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
        if ($element->name !== $this->parentTagName) {
            return Result::makeFailure(new UnprocessableEntityError(new Detail(
                FieldURI::from($this->fieldURI),
                Source::from(__METHOD__),
                Input::from($element->name),
                [new InvalidArgumentException(sprintf(
                    'Tag "%s" expected for attribute "%s".',
                    $this->parentTagName,
                    static::ATTRIBUTE_NAME,
                ))],
            )));
        }

        $attribute = $element->attributes->{static::ATTRIBUTE_NAME};
        if ($attribute === null) {
            return Result::makeFailure(new UnprocessableEntityError(
                new Detail(
                    FieldURI::from($this->fieldURI),
                    Source::from(__METHOD__),
                    Input::from($element),
                    [new InvalidArgumentException(
                        'Attribute {static::ATTRIBUTE_NAME} not found in provided XML string.'
                    )],
                )));
        }

        $attributeValue = $attribute->value;
        $valueValidation = $this->validateAttributeValue($attributeValue, $this->fieldURI);
        if ($valueValidation->isFailure()) {
            return $valueValidation;
        }

        $this->value = $attributeValue;
        $this->attribute = $attribute;

        return Result::makeSuccess($this);
    }

    /**
     * @return Result<null|ApiError>
     */
    final protected function validateAttributeValue(string $attributeValue, string $fieldURI): Result
    {
        $service = new ValidationService($fieldURI, __METHOD__);
        foreach ($this->attributeValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($attributeValue);
    }

    /** @return array<Validator> */
    abstract protected function attributeValueValidators(): array;

    final public function __toString(): string
    {
        if (isset($this->attribute)) {
            return (string) $this->attribute;
        }

        if (! isset($this->value)) {
            throw new RuntimeException(sprintf(
                'Property "%s::$value" must be initialized before serialization.',
                static::class
            ));
        }

        $escapedValue = htmlspecialchars($this->value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $this->attribute = new Attribute(static::ATTRIBUTE_NAME, $escapedValue);

        return (string) $this->attribute;
    }
}
