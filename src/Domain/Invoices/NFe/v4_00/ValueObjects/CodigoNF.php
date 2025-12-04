<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        6
 * ID       B03
 * Campo    cUF
 * Desc     Código Numérico que compõe a Chave de Acesso
 * Tam      8
 * OBS:
 * Código numérico que compõe a Chave de Acesso. Número aleatório
 * gerado pelo emitente para cada NF-e para evitar acessos
 * indevidos da NF-e. (v2.0)
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;

final class CodigoNF extends DFeElement
{
    public static string $tagName = 'cNF';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = DFeElement::xmlParser()->getTag($rawData, self::$tagName);
        $xmlTagValue = DFeElement::xmlParser()->getTagValue($xmlTagString, self::$tagName);

        return Result::makeSuccess(
            new CodigoNF(
                $xmlTagValue,
                $xmlTagString
            )
        );
    }
}
