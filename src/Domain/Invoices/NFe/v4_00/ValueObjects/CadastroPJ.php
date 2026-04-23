<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       BA13, C02, E02, F02, G02, GA02, X4
 * Campo    CNPJ
 * Desc     Cadastro nacional de Pessoa Juridica
 * Tam      14
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsCNPJValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CadastroPJ extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'CNPJ';

    private function __construct(public readonly string $xmlString)
    {
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

        return Result::makeSuccess(
            new self(
                $xmlString
            )
        );
    }

    protected static function tagValueValidators(): array
    {
        return [
            new IsCNPJValidator,
        ];
    }
}
