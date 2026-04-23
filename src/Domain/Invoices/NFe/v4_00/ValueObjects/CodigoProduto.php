<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       I02
 * Campo    cProd
 * Desc     Código do produto ou serviço
 * Tam      1-60
 * OBS:
 * Preencher com CFOP, caso se trate de itens não relacionados
 * com mercadorias/produtos e que o contribuinte não possua
 * codificação própria.
 * Formato: ”CFOP9999”
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\TextFormatValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;

final class CodigoProduto extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'cProd';

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
            new NotNullValidator,
            new MaxStringLengthValidator(60),
            new MinStringLengthValidator(1),
            new TextFormatValidator,
        ];
    }
}
