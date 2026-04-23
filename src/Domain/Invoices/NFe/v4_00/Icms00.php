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

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\AliquotaICMS;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndOrigem;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ModalidadeBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorBC;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class Icms00 extends DFeElement
{
    use ValidatesDFeGroupElement;

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
        $parserResponse = self::parser(
            $rawData,
            $parentFieldURI
        );
        if ($parserResponse->isFailure()) {
            return $parserResponse;
        }

        $parserData = $parserResponse->getData();
        $fieldURI = $parserData['fieldURI'];
        $xmlString = $parserData['xmlString'];

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

    protected static function tagElementsValidators(): array
    {
        return [
            new RequiredTagValidator(['orig', 'CST', 'modBC', 'vBC', 'pICMS', 'vICMS']),
        ];
    }
}
