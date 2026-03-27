<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        26
 * ID       B2
 * Campo    tpEmis
 * Desc     Tipo de Emissão da NF-e
 * Tam      1
 * OBS:
 * 1=Emissão normal (não em contingência);
 * 2=Contingência FS-IA, com impressão do DANFE em Formulário de
 * Segurança - Impressor Autônomo;
 * 3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional); *Desativado * NT 2015/002
 * 4=Contingência EPEC (Evento Prévio da Emissão em Contingência);
 * 5=Contingência FS-DA, com impressão do DANFE em Formulário de
 * Segurança - Documento Auxiliar;
 * 6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
 * 7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
 * 9=Contingência off-line da NFC-e;
 * Observação: Para a NFC-e somente é válida a opção de
 * contingência: 9-Contingência Off-Line e, a critério da
 * UF, opção 4-Contingência EPEC. (NT 2015/002)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoEmissaoValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeValueElement;
use InvalidArgumentException;

final class TipoEmissao extends DFeValueElement
{
    public static string $tagName = 'tpEmis';

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

        $tagValueValidationResponse = self::validateTagValue($xmlString, $fieldURI, $method);
        if (! $tagValueValidationResponse->isSuccess()) {
            return $tagValueValidationResponse;
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
        $validationService = new ValidationService(
            [
                NotNullValidator::class => [],
                IsNumericValidator::class => [],
                StringLengthValidator::class => [1],
                IsTipoEmissaoValidator::class => [],
            ],
            $fieldURI,
            $method
        );

        return $validationService->verify($tagValue);
    }
}
