<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        104d
 * ID       I05c
 * Campo    CEST
 * Desc     Código CEST (Código Especificador da Substituição Tributária) com 7 dígitos
 * Tam      2-8
 * OBS:
 * Campo CEST (Código Especificador da Substituição Tributária), que
 * estabelece a sistemática de uniformização e identificação das
 * mercadorias e bens passíveis de sujeição aos regimes de substituição
 * tributária e de antecipação de recolhimento do ICMS.
 * (Incluído na NT 2015/003. Atualizado NT2016.002)
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

final class CodigoSubstituicaoTributaria extends DFeElement
{
    public static string $tagName = 'CEST';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $typeValidator = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
        ]);

        $typeValidatorResponse = $typeValidator->verify($rawData);
        if (! $typeValidatorResponse->isSuccess()) {
            return $typeValidatorResponse;
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

        $validationValueResponse = self::validateTagValue($tagValue);
        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        return Result::makeSuccess(
            new self(
                $tagValue,
                self::generateXmlString(tagValue: $tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new StringLengthValidator(self::$tagName, 7),
            new IsNumericValidator(self::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($tagValue);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        return Result::makeSuccess();
    }
}
