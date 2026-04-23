<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B09
 * Campo    dhEmi
 * Desc     Data e hora de emissão do Documento Fiscal
 * Tam
 * OBS:
 * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

class DataHoraEmissao extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'dhEmi';

    private function __construct(public readonly string $xmlString)
    {
        $this->value = static::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? static::$tagName : $parentFieldURI . '.' . static::$tagName;
        $typeValidatorResponse = static::validateDataType($rawData, $fieldURI, $method);
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

    protected static function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new StringLengthValidator(25),
            new FormatDataHoraTZDValidator,
        ];
    }
}
