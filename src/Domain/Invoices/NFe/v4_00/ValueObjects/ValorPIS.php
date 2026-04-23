<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       Q09
 * Campo    vPIS
 * Desc     Valor do PIS
 * Tam      13v2
 * OBS:
 * Valor do PIS da operacao.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsDecimalValidator;
use BradiNfeApi\Domain\Common\Validators\MaxValueValidator;
use BradiNfeApi\Domain\Common\Validators\MinValueValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class ValorPIS extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'vPIS';

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
            new IsDecimalValidator(13, 2),
            new MaxValueValidator(9999999999999.99),
            new MinValueValidator(0),
        ];
    }
}
