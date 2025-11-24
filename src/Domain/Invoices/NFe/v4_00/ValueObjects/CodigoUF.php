<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        6
 * ID       B02
 * Campo    cUF
 * Desc     Código da UF do emitente do Documento Fiscal
 * Tam      2
 * OBS:
 * Utilizar a Tabela do IBGE de código de unidades da federação
 * (Seção 8.1 do MOC – Visão Geral, Tabela de UF, Município e País).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class CodigoUF extends DFeElement
{
    private function __construct(
        public readonly string $value,
        public readonly string $xmlString) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator('cUF'),
            new NotNullValidator('cUF'),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if ($validationServiceResponse->isSuccess()) {
            return Result::makeSuccess(
                new CodigoUF(
                    DFeElement::xmlParser()->getTagValue($rawData, 'cUF'),
                    DFeElement::xmlParser()->getTag($rawData, 'cUF')
                )
            );
        }

        return $validationServiceResponse;
    }
}
