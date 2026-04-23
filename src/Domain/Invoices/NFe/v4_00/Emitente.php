<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        30
 * ID       C01
 * Campo    emit
 * Desc     Identificação do emitente da NF-e
 * Tam
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NomeFantasia;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Emitente extends DFeElement
{
    use ValidatesDFeGroupElement;

    public static string $tagName = 'emit';

    private function __construct(
        public readonly string $xmlString,
        public readonly CadastroPJ $CNPJ,
        public readonly CadastroPF $CPF,
        public readonly Nome $xNome,
        public readonly NomeFantasia $xFant,
        public readonly EnderecoEmitente $endEmit,
        public readonly InscricaoEstadual $IE,

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
        $tagValueValidationResponse = self::validateTagValue($xmlString, $fieldURI, $method, isOptional: true);
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
            CadastroPJ::class,
            CadastroPF::class,
            Nome::class,
            NomeFantasia::class,
            EnderecoEmitente::class,
            InscricaoEstadual::class,
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

    protected static function tagElementsValidators(): array
    {
        return [
            new AtLeastOneTagValidator(['CNPJ', 'CPF']),
            new RequiredTagValidator(['xNome', 'enderEmit', 'IE', 'CRT']),
        ];
    }
}
