<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B12
 * Campo    cMunFG
 * Desc     Código do Município de Ocorrência do Fato Gerador
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioUFPrefixValidator;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioValidator;

final class CodigoMunicipioFatoGerador extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'cMunFG';

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

    protected static function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(7),
            new IsCodigoMunicipioValidator,
            new IsCodigoMunicipioUFPrefixValidator,
        ];
    }
}
