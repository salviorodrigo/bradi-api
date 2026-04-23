<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        108
 * ID       I09
 * Campo    vUnCom
 * Desc     Valor Unitário de Comercialização
 * Tam      1-6
 * OBS:
 * Informar o valor unitário de comercialização do produto, campo
 * meramente informativo, o contribuinte pode utilizar a precisão
 * desejada (0-10 decimais). Para efeitos de cálculo, o valor unitário
 * será obtido pela divisão do valor do produto pela quantidade
 * comercial. (v2.0)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ValorUnitarioComercial extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'vUnCom';

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

    protected static function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsDecimalValidator(11, 10),
            new MaxValueValidator(99999999999.9999999999),
            new MinValueValidator(0.0000000001),
        ];
    }
}
