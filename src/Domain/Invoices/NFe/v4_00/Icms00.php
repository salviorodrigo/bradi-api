<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        -
 * ID       N02
 * Campo    ICMS00
 * Desc     Grupo do ICMS 00
 * Tam
 * OBS:
 * Origem da mercadoria, CST, modalidade de BC, valor da BC,
 * aliquota e valor do ICMS da operacao propria.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Common\Services\ValidationService;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\AliquotaICMS;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndOrigem;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use InvalidArgumentException;

final class Icms00 extends DFeGroupElement
{
    public static string $tagName = 'ICMS00';

    private function __construct(
        public readonly string $xmlString,
        public readonly IndOrigem $orig,
        public readonly CodigoSituacaoTributaria $CST,
        public readonly ModalidadeBC $modBC,
        public readonly ValorBC $vBC,
        public readonly AliquotaICMS $pICMS,
        public readonly ValorICMS $vICMS,
    ) {
        $this->value = self::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? self::$tagName : $parentFieldURI . '.' . self::$tagName;
        $typeValidatorResponse = self::validateDataType($rawData, $fieldURI, $method);
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
            IndOrigem::class,
            CodigoSituacaoTributaria::class,
            ModalidadeBC::class,
            ValorBC::class,
            AliquotaICMS::class,
            ValorICMS::class,
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
        $validationService = new ValidationService([
            RequiredTagValidator::class => [['orig', 'CST', 'modBC', 'vBC', 'pICMS', 'vICMS'], $childNames],
        ], $fieldURI, $method);

        return $validationService->verify($xmlString);
    }
}
