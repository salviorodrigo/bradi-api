<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        39; 71; 86; 95;324i
 * ID       C10; E10; F07; G07; U14
 * Campo    cMun
 * Desc     Código do Município
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 * Informar ‘9999999 ‘para operações com o exterior.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidCodigoMunicipioError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

class CodigoMunicipio extends DFeElement
{
    public static string $tagName = 'cMun';

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

        $xmlTagString = DFeElement::xmlParser()->getTag($rawData, static::$tagName);
        $xmlTagValue = DFeElement::xmlParser()->getTagValue($xmlTagString, static::$tagName);

        if (! self::validateTagValue($xmlTagValue)) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidCodigoMunicipioError(static::$tagName),
                ])
            );
        }

        return Result::makeSuccess(
            new static(
                $xmlTagValue,
                $xmlTagString
            )
        );
    }

    public static function create(string $tagValue, array $elements = [], array $attributes = []): Result
    {
        if (! static::validateTagValue($tagValue)) {
            return Result::makeFailure(
                new ValidationError([
                    new InvalidCodigoMunicipioError(static::$tagName),
                ])
            );
        }

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

        return Result::makeSuccess(
            new static(
                $tagValue,
                static::generateXmlString($tagValue)
            )
        );
    }

    public static function validateTagValue(string $tagValue): bool
    {
        if (! is_numeric($tagValue)) {
            return false;
        }
        if (strlen($tagValue) != 7) {
            return false;
        }
        if (! (bool) UnidadeFederativa::tryFrom(substr($tagValue, 0, 2))) {
            return false;
        }

        $totalBase2 = 0;
        for ($pointer = 0; $pointer < strlen($tagValue) - 1; $pointer++) {
            $totalBase2 += (int) $tagValue[$pointer];
            if ($pointer % 2 != 0) {
                $totalBase2 += (int) $tagValue[$pointer];
            }
        }

        return (bool) ($tagValue[-1] == (string) ($totalBase2 % 10));
    }
}
