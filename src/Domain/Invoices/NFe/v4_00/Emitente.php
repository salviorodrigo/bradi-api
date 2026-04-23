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
        public readonly ?CadastroPJ $CNPJ,
        public readonly ?CadastroPF $CPF,
        public readonly Nome $xNome,
        public readonly ?NomeFantasia $xFant,
        public readonly EnderecoEmitente $endEmit,
        public readonly InscricaoEstadual $IE,

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
            ['class' => CadastroPJ::class, 'required' => false],
            ['class' => CadastroPF::class, 'required' => false],
            ['class' => Nome::class, 'required' => true],
            ['class' => NomeFantasia::class, 'required' => false],
            ['class' => EnderecoEmitente::class, 'required' => true],
            ['class' => InscricaoEstadual::class, 'required' => true],
        ];

        $parserErrorBag = [];
        $xmlElementsBag = [];
        foreach ($xmlElements as $element) {
            $elementXmlString = self::xmlParser($xmlString)->getFirst($element['class']::$tagName);
            if ($elementXmlString === '' && ! $element['required']) {
                $xmlElementsBag[] = null;

                continue;
            }

            $parsingResult = $element['class']::parse(
                $elementXmlString,
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
