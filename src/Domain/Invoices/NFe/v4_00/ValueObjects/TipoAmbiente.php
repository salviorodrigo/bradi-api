<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        28
 * ID       B24
 * Campo    tpAmb
 * Desc     Identificação do Ambiente
 * Tam      1
 * OBS:
 * 1=Produção;
 * 2=Homologação.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Validators\IsAmbienteEmissaoValidator;

final class TipoAmbiente extends DFeElement
{
    public static string $tagName = 'tpAmb';

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

        $xmlTagString = self::xmlParser()->getTag(strval($rawData), self::$tagName);
        $tagValue = self::xmlParser()->getTagValue($xmlTagString, self::$tagName);
        $validationValueResponse = self::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new self(
                $tagValue,
                $xmlTagString
            )
        );
    }

    public static function create(string $tagValue, array $elements = [], array $attributes = []): Result
    {
        $validationValueResponse = self::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

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

        return Result::makeSuccess(
            new self(
                $tagValue,
                self::generateXmlString($tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsNumericValidator(self::$tagName),
            new StringLengthValidator(self::$tagName, 1),
            new IsAmbienteEmissaoValidator(self::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($tagValue);

        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        return Result::makeSuccess();
    }
}
