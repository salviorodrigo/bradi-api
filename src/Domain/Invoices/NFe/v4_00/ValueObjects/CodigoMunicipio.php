<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C10; E10; F07; G07; U14
 * Campo    cMun
 * Desc     Código do Município
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 * Informar ‘9999999 ‘para operações com o exterior.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Services\OptionalValidation;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioValidator;
use BradiNfeApi\Domain\Invoices\Validators\IsUnidadeFederativaValidator;
use InvalidArgumentException;

class CodigoMunicipio extends DFeValueElement
{
    public static string $tagName = 'cMun';

    private function __construct(public readonly string $xmlString)
    {
        $this->value = static::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? static::$tagName : $parentFieldURI . '.' . static::$tagName;
        $typeValidatorResponse = static::validateDataType($rawData, $fieldURI, $method, isOptional: true);
        if ($typeValidatorResponse->isFailure()) {
            return $typeValidatorResponse;
        }

        $xmlString = static::xmlParser(strval($rawData))->getFirst(static::$tagName);
        $tagAttributesValidationResponse = static::validateTagAttributes($xmlString, $fieldURI, $method);
        if ($tagAttributesValidationResponse->isFailure()) {
            return $tagAttributesValidationResponse;
        }

        $tagElementsValidationResponse = static::validateTagElements($xmlString, $fieldURI, $method);
        if ($tagElementsValidationResponse->isFailure()) {
            return $tagElementsValidationResponse;
        }

        $validationValueResponse = static::validateTagValue($xmlString, $fieldURI, $method);
        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new static(
                $xmlString
            )
        );
    }

    public static function create(string $tagValue = '', array $elements = [], array $attributes = [], string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            if (! is_string($attributeName)) {
                throw new InvalidArgumentException('Attribute name must be a string. Found: ' . gettype($attributeName) . ' with value: ' . strval($attributeName));
            }

            if (! is_string($attributeValue)) {
                throw new InvalidArgumentException('Attribute value must be a string. Found: ' . gettype($attributeValue) . ' with value: ' . strval($attributeValue));
            }
        }

        foreach ($elements as $element) {
            if (! $element instanceof DFeElement) {
                throw new InvalidArgumentException('All elements must be instances of DFeElement. Found: ' . gettype($element) . ' with value: ' . strval($element));
            }
        }

        return static::parse(static::generateXmlString($tagValue, $elements, $attributes), $parentFieldURI, $method);
    }

    protected static function validateTagValue(string $xmlString, string $fieldURI, string $method): Result
    {
        $tagValue = static::xmlParser($xmlString)->getTextContent();
        $validationService = new ValidationService($fieldURI, $method)
            ->addValidator(new NotNullValidator)
            ->addValidator(new IsNumericValidator)
            ->addValidator(new StringLengthValidator(7))
            ->addValidator(new IsCodigoMunicipioValidator);

        $tagValueValidationResponse = (new OptionalValidation($validationService))->verify($tagValue);
        if (! $tagValueValidationResponse->isSuccess()) {
            return $tagValueValidationResponse;
        }

        if ($tagValue === '' || $tagValue === '9999999') {
            return Result::makeSuccess();
        }

        $validationService->reset();
        $validationService->addValidator(new IsUnidadeFederativaValidator);
        $validationUfResponse = $validationService->verify(substr($tagValue, 0, 2));
        if (! $validationUfResponse->isSuccess()) {
            return $validationUfResponse;
        }

        return Result::makeSuccess();
    }
}
