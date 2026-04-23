<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B03
 * Campo    cNF
 * Desc     Código Numérico que compõe a Chave de Acesso
 * Tam      8
 * OBS:
 * Código numérico que compõe a Chave de Acesso. Número aleatório
 * gerado pelo emitente para cada NF-e para evitar acessos
 * indevidos da NF-e. (v2.0)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\Validators\IsCodigoNFValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoNF extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'cNF';

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

        return Result::makeSuccess(new self($xmlString));
    }

    protected static function tagValueValidators(): array
    {
        return [
            new IsCodigoNFValidator,
        ];
    }
}
