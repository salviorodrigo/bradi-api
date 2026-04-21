<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        5
 * ID       B01
 * Campo    ide
 * Desc     Informações de identificação da NF-e
 * Tam
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\Services\OptionalValidation;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipioFatoGerador;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdDestino;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndFinal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModeloDFe;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NaturezaOperacao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use InvalidArgumentException;

final class IdentificacaoNF extends DFeElement
{
    use ValidatesDFeGroupElement;

    public static string $tagName = 'ide';

    private function __construct(
        public readonly string $xmlString,
        public readonly CodigoUF $cUF,
        public readonly CodigoNF $cNF,
        public readonly NaturezaOperacao $natOp,
        public readonly ModeloDFe $mod,
        public readonly Serie $serie,
        public readonly NumeroNF $nNF,
        public readonly DataHoraEmissao $dhEmi,
        public readonly TipoNF $tpNF,
        public readonly IdDestino $idDest,
        public readonly CodigoMunicipioFatoGerador $cMunFG,
        public readonly TipoEmissao $tpEmis,
        public readonly TipoAmbiente $tpAmb,
        public readonly FinalidadeNF $finNFe,
        public readonly IndFinal $indFinal
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
            CodigoUF::class,
            CodigoNF::class,
            NaturezaOperacao::class,
            ModeloDFe::class,
            Serie::class,
            NumeroNF::class,
            DataHoraEmissao::class,
            TipoNF::class,
            IdDestino::class,
            CodigoMunicipioFatoGerador::class,
            TipoEmissao::class,
            TipoAmbiente::class,
            FinalidadeNF::class,
            IndFinal::class,
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
            ->addValidator(new RequiredTagValidator(['cUF', 'cNF', 'natOp', 'mod', 'serie', 'nNF', 'dhEmi', 'tpNF', 'idDest', 'cMunFG', 'tpImp', 'tpEmis', 'cDV', 'tpAmb', 'finNFe', 'indFinal', 'indPres', 'procEmi', 'verProc'], $childNames));

        return (new OptionalValidation($validationService))->verify($xmlString);
    }
}
