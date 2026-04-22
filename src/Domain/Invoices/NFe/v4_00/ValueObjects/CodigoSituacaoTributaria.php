<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N12 / Q06 / S06
 * Campo    CST
 * Desc     Código da Situação Tributária
 * Tam      2
 * OBS:
 * Classe unificada para validação de CST nos grupos ICMS (N12),
 * PIS (Q06) e COFINS (S06).
 * 00=Tributada integralmente;
 * 01=Operação tributável com alíquota básica;
 * 02=Operação tributável com alíquota diferenciada;
 * 03=Operação tributável por unidade de medida;
 * 04=Tributação monofásica - revenda a alíquota zero;
 * 05=Substituição tributária;
 * 06=Alíquota zero;
 * 07=Isenta da contribuição;
 * 08=Sem incidência da contribuição;
 * 09=Suspensão da contribuição;
 * 10=Tributada e com cobrança do ICMS por substituição tributária;
 * 20=Com redução de base de cálculo;
 * 30=Isenta ou não tributada e com cobrança do ICMS por substituição tributária;
 * 40=Isenta;
 * 41=Não tributada;
 * 49=Outras operações de saída;
 * 50=Suspensão;
 * 51=Diferimento;
 * 52,53,54,55,56=Códigos de crédito vinculados à operação;
 * 60=ICMS cobrado anteriormente por substituição tributária;
 * 61,62,63,64,65,66,67=Códigos de crédito presumido;
 * 70=Com redução de base de cálculo e cobrança do ICMS por substituição tributária;
 * 71=Operação de aquisição com isenção;
 * 72=Operação de aquisição com suspensão;
 * 73=Operação de aquisição a alíquota zero;
 * 74=Operação de aquisição sem incidência;
 * 75=Operação de aquisição por substituição tributária;
 * 98=Outras operações de entrada;
 * 99=Outras operações.
 * 90=Outras.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoSituacaoTributariaValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use InvalidArgumentException;

final class CodigoSituacaoTributaria extends DFeElement
{
    use ValidatesDFeValueElement;

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

    protected static function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator(allowLeadingZeros: true),
            new StringLengthValidator(stringLength: 2),
            new IsTipoSituacaoTributariaValidator,
        ];
    }
}
