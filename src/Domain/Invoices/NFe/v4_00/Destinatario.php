<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        62
 * ID       E01
 * Campo    dest
 * Desc     Identificação do destinatario da NF-e
 * Tam
 * OBS:
 * Grupo Obrigatório para a NF-e (modelo 55).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorIEDestinatario;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Destinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public static string $tagName = 'dest';

    private function __construct(
        public readonly string $xmlString,
        public readonly CadastroPJ $CNPJ,
        public readonly CadastroPF $CPF,
        public readonly Nome $xNome,
        public readonly EnderecoDestinatario $endDest,
        public readonly IndicadorIEDestinatario $indIEDest,
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
            EnderecoDestinatario::class,
            IndicadorIEDestinatario::class,
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
            new AtLeastOneTagValidator(['CNPJ', 'CPF', 'idEstrangeiro']),
            new RequiredTagValidator(['indIEDest']),
        ];
    }
}
