<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        77a
 * ID       E16a
 * Campo    indIEDest
 * Desc     Indicador da IE do Destinatário
 * Tam      1
 * OBS:
 * 1=Contribuinte ICMS (informar a IE do destinatário);
 * 2=Contribuinte isento de Inscrição no cadastro de Contribuintes
 * 9=Não Contribuinte, que pode ou não possuir Inscrição Estadual
 * no Cadastro de Contribuintes do ICMS.
 * Nota 1: No caso de NFC-e informar indIEDest=9 e não informar a
 * tag IE do destinatário;
 * Nota 2: No caso de operação com o Exterior informar indIEDest=9 e
 * não informar a tag IE do destinatário;
 * Nota 3: No caso de Contribuinte Isento de Inscrição (indIEDest=2), não
 * informar a tag IE do destinatário.
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
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsTipoIndIEDestinatarioValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class IndicadorIEDestinatario extends DFeElement
{
    public static string $tagName = 'indIEDest';

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
            new IsTipoIndIEDestinatarioValidator(self::$tagName),
        ]);

        $validationServiceResponse = $validationService->verify($tagValue);

        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        return Result::makeSuccess();
    }
}
