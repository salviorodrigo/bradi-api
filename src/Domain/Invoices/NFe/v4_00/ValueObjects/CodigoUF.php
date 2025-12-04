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

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Enums\UnidadeFederativa;
use BradiNfeApi\Domain\Invoices\NFe\Exceptions\InvalidCodigoUFError;
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
            new IsXmlTagValidator('cUF'),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = DFeElement::xmlParser()->getTag($rawData, 'cUF');
        $xmlTagValue = DFeElement::xmlParser()->getTagValue($xmlTagString, 'cUF');

        if (! UnidadeFederativa::from($xmlTagValue)) {
            Result::makeFailure([
                new ValidationError(
                    new InvalidCodigoUFError('cUF')),
            ]);
        }

        return Result::makeSuccess(
            new CodigoUF(
                $xmlTagValue,
                $xmlTagString
            )
        );
    }
}
