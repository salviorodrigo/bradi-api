<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        26
 * ID       B2
 * Campo    tpEmis
 * Desc     Tipo de Emissão da NF-e
 * Tam      1
 * OBS:
 * 1=Emissão normal (não em contingência);
 * 2=Contingência FS-IA, com impressão do DANFE em Formulário de
 * Segurança - Impressor Autônomo;
 * 3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional); *Desativado * NT 2015/002
 * 4=Contingência EPEC (Evento Prévio da Emissão em Contingência);
 * 5=Contingência FS-DA, com impressão do DANFE em Formulário de
 * Segurança - Documento Auxiliar;
 * 6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
 * 7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
 * 9=Contingência off-line da NFC-e;
 * Observação: Para a NFC-e somente é válida a opção de
 * contingência: 9-Contingência Off-Line e, a critério da
 * UF, opção 4-Contingência EPEC. (NT 2015/002)
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
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoEmissaoValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\HasValue;

final class TipoEmissao extends DFeElement implements HasValue
{
    public static string $tagName = 'tpEmis';

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
            new IsTipoEmissaoValidator(self::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($tagValue);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        return Result::makeSuccess();
    }
}
