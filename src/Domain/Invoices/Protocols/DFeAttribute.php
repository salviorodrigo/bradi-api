<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Exceptions\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\FieldURI;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\ValueObjects\Source;
use BradiNfeApi\Domain\Invoices\Protocols\DFeParser;
use BradiNfeApi\Infra\Parses\XmlToDFeParser;
use InvalidArgumentException;
use RuntimeException;

abstract class DFeAttribute
{
    public const string ATTRIBUTE_NAME = '';

    public string $value;
    public protected(set) string $xmlString;
    public readonly string $parentTagName;
    public readonly string $fieldURI;

    public function __construct(string $parentFieldURI)
    {
        if ($parentFieldURI === '') {
            throw new RuntimeException(sprintf(
                'Parent field URI must be provided for attribute "%s".',
                static::ATTRIBUTE_NAME
            ));
        }
        $parents = explode('.', $parentFieldURI);
        $this->parentTagName = array_pop($parents);   
        $this->fieldURI =  $parentFieldURI . '.' . static::ATTRIBUTE_NAME;
    }

    protected static function xmlParser(string $xmlString): DFeParser
    {
        return new XmlToDFeParser($xmlString);
    }

    final public function __toString(): string
    {
        if (isset($this->xmlString)) {
            return $this->xmlString;
        }

        if (! isset($this->value)) {
            throw new RuntimeException(sprintf(
                'Property "%s::$value" must be initialized before serialization.',
                static::class
            ));
        }

        $escapedValue = htmlspecialchars($this->value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $this->xmlString = static::ATTRIBUTE_NAME . '="' . $escapedValue . '"';

        return $this->xmlString;
    }

    /**
     * @return Result<DFeAttribute|ApiError>
     */
    final public function parse(mixed $rawData): Result
    {
        $dataTypeValidation = $this->validateDataType($rawData, $this->fieldURI);
        if ($dataTypeValidation->isFailure()) {
            return $dataTypeValidation;
        }

        $attributes = $this->xmlParser((string) $rawData)->listAttributes();
        if (! array_key_exists(static::ATTRIBUTE_NAME, $attributes) ) {
            return Result::makeFailure(new UnprocessableEntityError(
                new Detail(
                    FieldURI::from($this->fieldURI), 
                    Source::from(__METHOD__)                , 
                    Input::from($rawData),
                    [new InvalidArgumentException(
                        "Attribute {static::ATTRIBUTE_NAME} not found in provided XML string."
                    )],
            ))); 
        }

        $attributeValue = $attributes[static::ATTRIBUTE_NAME];
        $valueValidation = $this->validateAttributeValue($attributeValue, $this->fieldURI);
        if ($valueValidation->isFailure()) {
            return $valueValidation;
        }

        $this->value = $attributeValue;

        return Result::makeSuccess($this);
    }

    /**
     * @return Result<null|ApiError>
     */
    final protected function validateDataType(mixed $rawData, string $fieldURI): Result
    {
        $typeValidator = new ValidationService($fieldURI, __METHOD__);
        $typeValidator->addValidator(new IsStringValidator);

        return $typeValidator->verify($rawData);
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
}
