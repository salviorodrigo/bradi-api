<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Protocols;

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\Protocols\Validator;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeAttribute;
use BradiNfeApi\Domain\Invoices\Validators\RootTagValidator;
use BradiNfeApi\Domain\Xml\ValueObjects\Attribute;
use BradiNfeApi\Domain\Xml\ValueObjects\Element;
use BradiNfeApi\Infra\Parses\XmlStringIterator;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;

abstract class DFeElement
{
    public const string TAG_NAME = '';
    
    public readonly string $fieldURI;
    public ?string $value;
    private ?Element $sourceElement;

    public function __construct(string $parentFieldURI = '')
    {
        $this->fieldURI = $parentFieldURI === '' ? self::TAG_NAME : $parentFieldURI . '.' . self::TAG_NAME;
    }

    /** @return array<Validator> */
    abstract protected function tagValueValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagAttributesValidators(): array;

    /** @return array<Validator> */
    abstract protected function tagElementsValidators(): array;

    /** @return Result<DFeElement|ApiError> */
    final public function parseFromXmlElement(Element $element): Result
    {
        $validationSteps = [
            fn ($candidate) => $this->validateRootTag($candidate),
            fn ($candidate) => $this->validateTagAttributes($candidate),
            fn ($candidate) => $this->validateTagElements($candidate),
            fn ($candidate) => $this->validateTagValue($candidate),
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

    /** @return Result<null|ApiError> */
    final protected function validateRootTag(Element $element): Result
    {
        $service = new ValidationService($this->fieldURI, __METHOD__);
        $service->addValidator(new RootTagValidator(static::TAG_NAME));

        return $service->verify($element);
    }

    /** @return Result<null|ApiError> */
    final protected function validateTagValue(Element $element): Result
    {
        $candidate = $element->value ?? '';
        $service = new ValidationService($this->fieldURI, __METHOD__);
        foreach ($this->tagValueValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($candidate);
    }

    /** @return Result<null|ApiError> */
    final protected function validateTagAttributes(Element $element): Result
    {
        $service = new ValidationService($this->fieldURI, __METHOD__);
        foreach ($this->tagAttributesValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($element);
    }

    /**  @return Result<null|ApiError> */
    final protected function validateTagElements(Element $element): Result
    {
        $service = new ValidationService($this->fieldURI, __METHOD__);
        foreach ($this->tagElementsValidators() as $validator) {
            $service->addValidator($validator);
        }

        return $service->verify($element);
    }

    final public function __toString(): string
    {
        if (isset($this->sourceElement)) {
            // verify is all  delcared and stted properties are setted into Element instance, if not, set them before return the string ordenation is important. Verify if all values are equals, if not, update the Element instance with the current values. If all values are equals, return the string. 
            return (string) $this->sourceElement;
        }

        $validationService = new ValidationService($this->fieldURI, __METHOD__);
        $this->sourceElement = new Element(new XmlStringIterator($validationService), $validationService);
        $this->sourceElement->name = static::TAG_NAME;

        if (isset($this->value)) {
            $this->sourceElement->value = $this->value;
        }

        $propsMetadata = $this->listChildElements();
        if (! empty($propsMetadata)) {
            $elementsList = array_filter($propsMetadata, fn (array $element) => $element['parentClass'] === DFeElement::class);
            $attributesList = array_filter($propsMetadata, fn (array $element) => $element['parentClass'] === DFeAttribute::class);

            foreach ($attributesList as $attribute) {
                if (! isset($this->{$attribute['propertyName']}) && ! $attribute['isOptional']) {
                    throw new RuntimeException(sprintf(
                        'Required attribute "%s" not initialized.',
                        $attribute['propertyName']
                    ));
                }

                if (! isset($this->{$attribute['propertyName']})) {
                    continue;
                }

                $attributeInstance = new Attribute(
                    $attribute['propertyName'], 
                    $this->{$attribute['propertyName']}->value
                );

                $this->sourceElement->addAttribute($attributeInstance);
            }

            foreach ($elementsList as $element) {
                if (! isset($this->{$element['propertyName']}) && ! $element['isOptional']) {
                    throw new RuntimeException(sprintf(
                        'Required element "%s" not initialized.',
                        $element['propertyName']
                    ));
                }

                if (! isset($this->{$element['propertyName']})) {
                    continue;
                }

                $elementInstance = new Element(new XmlStringIterator($validationService), $validationService);
                $elementInstance->parse((string) $this->{$element['propertyName']});
                $this->sourceElement->addChild($elementInstance);
            }
        }

        return (string) $this;
    }

    /** @return Result<null|ApiError> **/
    private function hydrateFromXmlElement(Element $xmlElement): Result
    {
        if (isset($xmlElement->value)) {
            $this->value = $xmlElement->value;
        }

        $propsMetadata = $this->listChildElements();
        [$requiredElements, $optionalElements] = array_reduce($propsMetadata, function (array $carry, array $element) {
            $element['isOptional'] ? $carry[1][] = $element : $carry[0][] = $element;

            return $carry;
        }, [[], []]);

        $parserErrorBag = [];
        foreach ($requiredElements as $element) {
            $concreteElement = new $element['class']($this->fieldURI);
            $parsingResult = $concreteElement->parseFromXmlElement($xmlElement->{static::TAG_NAME});
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['propertyName']} = $parsingResult->getData();
        }

        foreach ($optionalElements as $element) {
            if (! isset($xmlElement->{static::TAG_NAME})) {
                continue;
            }

            $concreteElement = new $element['class']($this->fieldURI);
            $parsingResult = $concreteElement->parseFromXmlElement($xmlElement->{static::TAG_NAME});
            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();

                continue;
            }

            $this->{$element['propertyName']} = $parsingResult->getData();
        }

        if (count($parserErrorBag) > 0) {
            $parsingError = array_shift($parserErrorBag);
            foreach ($parserErrorBag as $error) {
                $parsingError->merge($error);
            }

            return Result::makeFailure($parsingError);
        }
            
        $this->sourceElement = $xmlElement;

        return Result::makeSuccess();
    }
    
     /** @return array<array{parentClass: string, class:string,propertyName:string,isOptional:bool,isSet:bool}> */
    private function listChildElements(): array
    {
        $elementsList = []; 
        $reflection = new ReflectionClass($this);
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (! $property->hasType()) {
                continue;
            }

            $propertyType = $property->getType();
            if (! $propertyType instanceof ReflectionNamedType || $propertyType->isBuiltin()) {
                continue;
            }

            $elementClass = new ReflectionClass($propertyType->getName());
            $parentClass = $elementClass->getParentClass();
            $allowedClasses = [DFeElement::class, DFeAttribute::class];
            if (! array_reduce($allowedClasses, fn (bool $carry, string $allowedClass) => $carry || is_a($parentClass->getName(), $allowedClass, true), false)) {
                continue;
            }

            $elementsList[] = [
                'parentClass' => $parentClass->getName(),
                'class' => $elementClass->getName(),
                'propertyName' => $property->getName(),
                'isOptional' => $propertyType->allowsNull(),
                'isSet' => isset($this->{$property->getName()})
            ];
        }

        return $elementsList;
    }
}

// TODO Make test file.
