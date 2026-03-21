<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N12
 * Campo    CST
 * Desc     Código da Situação Tributária
 * Tam      2
 * OBS:
 * 00=Tributada integralmente;
 * 10=Tributada e com cobrança do ICMS por substituição tributária;
 * 20=Com redução de base de cálculo;
 * 30=Isenta ou não tributada e com cobrança do ICMS por substituição tributária;
 * 40=Isenta;
 * 41=Não tributada;
 * 50=Suspensão;
 * 51=Diferimento;
 * 60=ICMS cobrado anteriormente por substituição tributária;
 * 70=Com redução de base de cálculo e cobrança do ICMS por substituição tributária;
 * 90=Outras.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Services\ValidationService;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoSituacaoTributariaValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeValueElement;
use InvalidArgumentException;

final class CodigoSituacaoTributaria extends DFeValueElement
{
    public static string $tagName = 'CST';

    private function __construct(public readonly string $xmlString)
    {
        $this->value = self::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? self::$tagName : $parentFieldURI . '.' . self::$tagName;
        $typeValidatorResponse = self::validateDataType($rawData, $fieldURI, $method);
        if ($typeValidatorResponse->isFailure()) {
            return $typeValidatorResponse;
        }

        $xmlString = self::xmlParser(strval($rawData))->getFirst(self::$tagName);
        $tagAttributesValidationResponse = self::validateTagAttributes($xmlString, $fieldURI, $method);
        if ($tagAttributesValidationResponse->isFailure()) {
            return $tagAttributesValidationResponse;
        }

        $tagElementsValidationResponse = self::validateTagElements($xmlString, $fieldURI, $method);
        if ($tagElementsValidationResponse->isFailure()) {
            return $tagElementsValidationResponse;
        }

        $validationValueResponse = self::validateTagValue($xmlString, $fieldURI, $method);
        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new self(
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

        return self::parse(self::generateXmlString($tagValue, $elements, $attributes), $parentFieldURI, $method);
    }

    protected static function validateTagValue(string $xmlString, string $fieldURI = '', string $method = __METHOD__): Result
    {
        $tagValue = self::xmlParser($xmlString)->getTextContent();
        $validationService = new ValidationService([
            NotNullValidator::class => [],
            IsNumericValidator::class => ['allowLeadingZeros' => true],
            StringLengthValidator::class => [2],
            IsTipoSituacaoTributariaValidator::class => [],
        ], $fieldURI, $method);

        return $validationService->verify($tagValue);
    }
}
