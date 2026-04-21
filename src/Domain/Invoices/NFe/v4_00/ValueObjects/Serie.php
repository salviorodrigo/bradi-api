<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B07
 * Campo    serie
 * Desc     Série do Documento Fiscal
 * Tam      1-3
 * OBS:
 * Série do Documento Fiscal, preencher com zeros na hipótese
 * de a NF-e não possuir série. Série na faixa:
 * - [000-889]: Aplicativo do Contribuinte; Emitente=CNPJ; Assinatura
 * pelo e-CNPJ do contribuinte (procEmi<>1,2);
 *
 * - [890-899]: Emissão no site do Fisco (NFA-e - Avulsa);
 * Emitente= CNPJ / CPF; Assinatura pelo e-CNPJ da SEFAZ (procEmi=1);
 *
 * - [900-909]: Emissão no site do Fisco (NFA-e); Emitente= CNPJ; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CNPJ do
 * contribuinte (procEmi=2);
 *
 * - [910-919]: Emissão no site do Fisco (NFA-e); Emitente= CPF; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CPF do
 * contribuinte (procEmi=2);
 *
 * - [920-969]: Aplicativo do Contribuinte; Emitente=CPF; Assinatura pelo
 *  e-CPF do contribuinte (procEmi<>1,2);
 * (Atualizado NT 2018/001)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use InvalidArgumentException;

final class Serie extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'serie';

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
        $validationService = new ValidationService($fieldURI, $method)
            ->addValidator(new NotNullValidator)
            ->addValidator(new MaxStringLengthValidator(3))
            ->addValidator(new MinValueValidator(0))
            ->addValidator(new MaxValueValidator(969));

        return $validationService->verify($tagValue);
    }
}
