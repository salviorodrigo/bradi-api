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
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeGroupElement;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

final class EnderecoDestinatario extends DFeElement
{
    use ValidatesDFeGroupElement;

    public static string $tagName = 'enderDest';

    private function __construct(
        public readonly string $xmlString,
        public readonly Logradouro $xLgr,
        public readonly NumeroEndereco $nro,
        public readonly ?ComplementoEndereco $Cpl,
        public readonly Bairro $xBairro,
        public readonly CodigoMunicipio $cMun,
        public readonly NomeMunicipio $xMun,
        public readonly SiglaUF $UF,
        public readonly CodigoPostal $CEP,
        public readonly ?CodigoPais $cPais,
        public readonly ?NomePais $xPais,
        public readonly ?Telefone $fone,
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
            ['class' => Logradouro::class, 'required' => true],
            ['class' => NumeroEndereco::class, 'required' => true],
            ['class' => ComplementoEndereco::class, 'required' => false],
            ['class' => Bairro::class, 'required' => true],
            ['class' => CodigoMunicipio::class, 'required' => true],
            ['class' => NomeMunicipio::class, 'required' => true],
            ['class' => SiglaUF::class, 'required' => true],
            ['class' => CodigoPostal::class, 'required' => true],
            ['class' => CodigoPais::class, 'required' => false],
            ['class' => NomePais::class, 'required' => false],
            ['class' => Telefone::class, 'required' => false],
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
            new RequiredTagValidator(['xLgr', 'nro', 'xBairro', 'cMun', 'xMun', 'UF', 'CEP']),
        ];
    }
}
