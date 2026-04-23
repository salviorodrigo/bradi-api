<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       C10; E10; F07; G07; U14
 * Campo    cMun
 * Desc     Código do Município
 * Tam      7
 * OBS:
 * Informar o município de ocorrência do fato gerador do ICMS.
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 * Informar ‘9999999 ‘para operações com o exterior.
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioUFPrefixValidator;
use BradiNfeApi\Domain\Invoices\Validators\IsCodigoMunicipioValidator;

class CodigoMunicipio extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'cMun';

    private function __construct(public readonly string $xmlString)
    {
        $this->value = static::xmlParser($xmlString)->getTextContent();
    }

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $parserResponse = static::parser(
            $rawData,
            $parentFieldURI
        );
        if ($parserResponse->isFailure()) {
            return $parserResponse;
        }

        $parserData = $parserResponse->getData();
        $fieldURI = $parserData['fieldURI'];
        $xmlString = $parserData['xmlString'];

        return Result::makeSuccess(
            new static(
                $xmlString
            )
        );
    }

    protected static function tagValueValidators(): array
    {
        return [
            new NotNullValidator,
            new IsNumericValidator,
            new StringLengthValidator(7),
            new IsCodigoMunicipioValidator,
            new IsCodigoMunicipioUFPrefixValidator,
        ];
    }
}
