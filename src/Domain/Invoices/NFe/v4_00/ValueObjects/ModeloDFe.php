<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * ID       B06
 * Campo    mod
 * Desc     Código do Modelo do Documento Fiscal
 * Tam      2
 * OBS:
 * 55=NF-e emitida em substituição ao modelo 1 ou 1A;
 * 65=NFC-e, utilizada nas operações de venda no
 * varejo (a critério da UF aceitar este modelo de documento).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Traits\ValidatesDFeValueElement;
use BradiNfeApi\Domain\Invoices\Validators\IsModeloDFeValidator;

final class ModeloDFe extends DFeElement
{
    use ValidatesDFeValueElement;

    public static string $tagName = 'mod';

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
            new IsNumericValidator,
            new StringLengthValidator(2),
            new IsModeloDFeValidator,
        ];
    }
}
