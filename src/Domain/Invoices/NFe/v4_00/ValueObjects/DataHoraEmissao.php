<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        13
 * ID       B09
 * Campo    dhEmi
 * Desc     Data e hora de emissão do Documento Fiscal
 * Tam
 * OBS:
 * Data e hora no formato UTC (Universal Coordinated Time): AAAA-MM-DDThh:mm:ssTZD
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

class DataHoraEmissao extends DFeElement
{
    public static string $tagName = 'dhEmi';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(static::$tagName),
            new NotNullValidator(static::$tagName),
            new IsXmlTagValidator(static::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($rawData);

        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = static::xmlParser()->getTag(strval($rawData), static::$tagName);
        $tagValue = static::xmlParser()->getTagValue($xmlTagString, static::$tagName);
        $validationValueResponse = static::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new static(
                $tagValue,
                $xmlTagString
            )
        );
    }

    public static function create(string $tagValue = '', array $elements = [], array $attributes = []): Result
    {

        if (count($attributes) > 0) {
            return Result::makeFailure(
                new ValidationError([
                    new XmlElementWithAttributesError(static::$tagName),
                ])
            );
        }

        if (count($elements) > 0) {
            return Result::makeFailure(
                new ValidationError([
                    new XmlElementWithElementsError(static::$tagName),
                ])
            );
        }

        $validationValueResponse = static::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new static(
                $tagValue,
                static::generateXmlString(tagValue: $tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(static::$tagName),
            new NotNullValidator(static::$tagName),
            new StringLengthValidator(static::$tagName, 25),
            new FormatDataHoraTZDValidator(static::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($tagValue);

        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        return Result::makeSuccess();
    }
}
