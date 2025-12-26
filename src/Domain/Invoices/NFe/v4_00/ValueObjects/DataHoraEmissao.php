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
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidDateTimeFormatError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class DataHoraEmissao extends DFeElement
{
    public static string $tagName = 'dhEmi';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = DFeElement::xmlParser()->getTag($rawData, self::$tagName);
        $xmlTagValue = DFeElement::xmlParser()->getTagValue($xmlTagString, self::$tagName);

        if (! self::validateTagValue($xmlTagValue)) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidDateTimeFormatError(self::$tagName),
                ])
            );
        }

        return Result::makeSuccess(
            new DataHoraEmissao(
                $xmlTagValue,
                $xmlTagString
            )
        );
    }

    public static function create(string $tagValue = '', array $elements = [], array $attributes = []): Result
    {

        if (count($attributes) > 0) {
            return Result::makeFailure(
                new ValidationError([
                    new XmlElementWithAttributesError(self::$tagName),
                ])
            );
        }

        if (count($elements) > 0) {
            return Result::makeFailure(
                new ValidationError([
                    new XmlElementWithElementsError(self::$tagName),
                ])
            );
        }

        if ($tagValue == '') {
            $tagValue = '0';
        }

        if (! self::validateTagValue(($tagValue))) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidDateTimeFormatError(self::$tagName),
                ])
            );
        }

        return Result::makeSuccess(
            new DataHoraEmissao(
                $tagValue,
                self::generateXmlString(tagValue: $tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): bool
    {
        return (bool) preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])T([01]\d|2[0-3]):[0-5]\d:[0-5]\d([+-]\d{2}:\d{2})$/', $tagValue);
    }
}
