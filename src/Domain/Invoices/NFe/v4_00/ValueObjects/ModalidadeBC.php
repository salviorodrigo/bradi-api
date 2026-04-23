<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       N13
 * Campo    modBC
 * Desc     Modalidade de determinação da BC do ICMS
 * Tam      1
 * OBS:
 * 0=Margem Valor Agregado (%);
 * 1=Pauta (Valor);
 * 2=Preço Tabelado Máx. (valor);
 * 3=Valor da operação.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoModalidadeBCValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ModalidadeBC extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'modBC';

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
            new IsNumericValidator(true),
            new StringLengthValidator(1),
            new IsTipoModalidadeBCValidator,
        ];
    }
}
