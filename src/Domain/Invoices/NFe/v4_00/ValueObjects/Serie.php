<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        11
 * ID       B07
 * Campo    serie
 * Desc     Série do Documento Fiscal
 * Tam      1-3
 * OBS:
 * Série do Documento Fiscal, preencher com zeros na hipótese
 * de a NF-e não possuir série. Série na faixa:
 * - [000-889]: Aplicativo do Contribuinte; Emitente=CNPJ; Assinatura
 * pelo e-CNPJ do contribuinte (procEmi<>1,2);
 *
 * - [890-899]: Emissão no site do Fisco (NFA-e - Avulsa);
 * Emitente= CNPJ / CPF; Assinatura pelo e-CNPJ da SEFAZ (procEmi=1);
 *
 * - [900-909]: Emissão no site do Fisco (NFA-e); Emitente= CNPJ; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CNPJ do
 * contribuinte (procEmi=2);
 *
 * - [910-919]: Emissão no site do Fisco (NFA-e); Emitente= CPF; Assinatura
 * pelo e-CNPJ da SEFAZ (procEmi=1), ou Assinatura pelo e-CPF do
 * contribuinte (procEmi=2);
 *
 * - [920-969]: Aplicativo do Contribuinte; Emitente=CPF; Assinatura pelo
 *  e-CPF do contribuinte (procEmi<>1,2);
 * (Atualizado NT 2018/001)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidSerieError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithAttributesError;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\XmlElementWithElementsError;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class Serie extends DFeElement
{
    public static string $tagName = 'serie';

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

        if ((int) $xmlTagValue < 0 || (int) $xmlTagValue > 969) {
            Result::makeFailure([
                new InvalidSerieError(self::$tagName),
            ]);
        }

        return Result::makeSuccess(
            new Serie(
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

        if ((int) $tagValue < 0 || (int) $tagValue > 969) {
            Result::makeFailure([
                new InvalidSerieError(self::$tagName),
            ]);
        }

        return Result::makeSuccess(
            new Serie(
                $tagValue,
                self::generateXmlString(tagValue: $tagValue)
            )
        );
    }
}
