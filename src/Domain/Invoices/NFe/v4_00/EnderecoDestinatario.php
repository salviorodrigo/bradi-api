<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        66
 * ID       E05
 * Campo    enderDest
 * Desc     Endereço do destinatario
 * Tam
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\Services\OptionalValidation;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Bairro;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipio;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPais;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPostal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ComplementoEndereco;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Logradouro;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeMunicipio;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomePais;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroEndereco;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\SiglaUF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Telefone;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use InvalidArgumentException;

final class EnderecoDestinatario extends DFeGroupElement
{
    public static string $tagName = 'enderDest';

    private function __construct(
        public readonly string $xmlString,
        public readonly Logradouro $xLgr,
        public readonly NumeroEndereco $nro,
        public readonly ComplementoEndereco $Cpl,
        public readonly Bairro $xBairro,
        public readonly CodigoMunicipio $cMun,
        public readonly NomeMunicipio $xMun,
        public readonly SiglaUF $UF,
        public readonly CodigoPostal $CEP,
        public readonly CodigoPais $cPais,
        public readonly NomePais $xPais,
        public readonly Telefone $fone,
    ) {
        $this->value = self::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? self::$tagName : $parentFieldURI . '.' . self::$tagName;
        $typeValidatorResponse = self::validateDataType($rawData, $fieldURI, $method, isOptional: true);
        if (! $typeValidatorResponse->isSuccess()) {
            return $typeValidatorResponse;
        }

        $xmlString = self::xmlParser(strval($rawData))->getFirst(self::$tagName);
        $tagValueValidationResponse = self::validateTagValue($xmlString, $fieldURI, $method);
        if (! $tagValueValidationResponse->isSuccess()) {
            return $tagValueValidationResponse;
        }

        $tagAttributesValidationResponse = self::validateTagAttributes($xmlString, $fieldURI, $method);
        if ($tagAttributesValidationResponse->isFailure()) {
            return $tagAttributesValidationResponse;
        }

        $tagElementsValidationResponse = self::validateTagElements($xmlString, $fieldURI, $method);
        if ($tagElementsValidationResponse->isFailure()) {
            return $tagElementsValidationResponse;
        }

        $xmlElements = [
            Logradouro::class,
            NumeroEndereco::class,
            ComplementoEndereco::class,
            Bairro::class,
            CodigoMunicipio::class,
            NomeMunicipio::class,
            SiglaUF::class,
            CodigoPostal::class,
            CodigoPais::class,
            NomePais::class,
            Telefone::class,
        ];

        $parserErrorBag = [];
        $xmlElementsBag = [];
        foreach ($xmlElements as $element) {
            $parsingResult = $element::parse(
                self::xmlParser($xmlString)->getFirst($element::$tagName),
                $fieldURI,
                $method
            );

            if ($parsingResult->isFailure()) {
                $parserErrorBag[] = $parsingResult->getError();
            } else {
                $xmlElementsBag[] = $parsingResult->getData();
            }
        }

        if (count($parserErrorBag) > 0) {
            $parsingError = array_shift($parserErrorBag);
            foreach ($parserErrorBag as $error) {
                $parsingError->merge($error);
            }

            return Result::makeFailure($parsingError);
        }

        return Result::makeSuccess(
            new self(
                $xmlString,
                ...$xmlElementsBag
            )
        );
    }

    public static function create(string $tagValue = '', array $elements = [], array $attributes = [], string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        foreach ($attributes as $attributeName => $attributeValue) {
            if (! is_string($attributeName)) {
                throw new InvalidArgumentException('Attribute name must be a string. Found: ' . gettype($attributeName) . ' with value: ' . strval($attributeName));
            }

            if (! is_string($attributeValue)) {
                throw new InvalidArgumentException('Attribute value must be a string. Found: ' . gettype($attributeValue) . ' with value: ' . strval($attributeValue));
            }
        }

        foreach ($elements as $element) {
            if (! $element instanceof DFeElement) {
                throw new InvalidArgumentException('All elements must be instances of DFeElement. Found: ' . gettype($element) . ' with value: ' . strval($element));
            }
        }

        return self::parse(self::generateXmlString($tagValue, $elements, $attributes), $parentFieldURI, $method);
    }

    protected static function validateTagElements(string $xmlString, string $fieldURI, string $method): Result
    {
        $children = self::xmlParser($xmlString)->listChildren();
        $childNames = array_keys($children);
        $validationService = new ValidationService($fieldURI, $method)
            ->addValidator(new RequiredTagValidator(['xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP'], $childNames));

        return (new OptionalValidation($validationService))->verify($xmlString);
    }
}
