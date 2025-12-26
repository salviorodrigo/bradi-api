<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        12
 * ID       B08
 * Campo    nNF
 * Desc     Número do Documento Fiscal
 * Tam      1-9
 * OBS:
 * Número do Documento Fiscal
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidNumeroNFError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class NumeroNF extends DFeElement
{
    public static string $tagName = 'nNF';

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

        if (! NumeroNF::validateTagValue($xmlTagValue)) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidNumeroNFError(self::$tagName),
                ])
            );
        }

        return Result::makeSuccess(
            new NumeroNF(
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
            $tagValue = '1';
        }

        if (! NumeroNF::validateTagValue($tagValue)) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidNumeroNFError(self::$tagName),
                ])
            );
        }

        return Result::makeSuccess(
            new NumeroNF(
                $tagValue,
                self::generateXmlString(tagValue: $tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): bool
    {
        return is_numeric($tagValue) && (int) $tagValue > 0 && (int) $tagValue <= 999999999;
    }
}
