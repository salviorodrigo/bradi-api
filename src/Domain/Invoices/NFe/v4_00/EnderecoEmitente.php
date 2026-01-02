<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        34
 * ID       C05
 * Campo    enderEmit
 * Desc     Endereço do emitente
 * Tam
 * OBS:
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Common\Exceptions\ValidationErrorBag;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
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
use BradiNfeApi\Domain\Invoices\Protocols\DFeElementsGroup;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use Exception;

final class EnderecoEmitente extends DFeElementsGroup
{
    public static string $tagName = 'enderEmit';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString,
        public readonly Logradouro $xLgr,
        public readonly NumeroEndereco $nro,
        public readonly ComplementoEndereco $Cpl,
        public readonly Bairro $xBairro,
        public readonly CodigoMunicipio $cMun,
        public readonly NomeMunicipio $xMun,
        public readonly SiglaUF $UF,
        public readonly CodigoPostal $CEP,
        public readonly CodigoPais $cPais,
        public readonly NomePais $xPais,
        public readonly Telefone $fone,
    ) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
            new RequiredTagValidator(self::$tagName),
            new RequiredTagValidator('xLgr'),
            new RequiredTagValidator('nro'),
            new RequiredTagValidator('xBairro'),
            new RequiredTagValidator('cMun'),
            new RequiredTagValidator('xMun'),
            new RequiredTagValidator('UF'),
            new RequiredTagValidator('CEP'),
        ]);

        $validationServiceResponse = $validationService->verify($rawData);

        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = self::xmlParser()->getTag(strval($rawData), self::$tagName);
        $tagValue = self::xmlParser()->getTagValue($xmlTagString, self::$tagName);
        $validationValueResponse = self::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        // TODO Validar cPais como permitido apenas 1058
        // TODO Validar xPais como permitido apenas Brasil/BRASIL

        $xmlElements = [
            Logradouro::class,
            NumeroEndereco::class,
            ComplementoEndereco::class,
            Bairro::class,
            CodigoMunicipio::class,
            NomeMunicipio::class,
            SiglaUF::class,
            CodigoPostal::class,
            CodigoPais::class,
            NomePais::class,
            Telefone::class,
        ];

        $parserErrorBag = new ValidationErrorBag;
        $xmlElementsBag = [];

        foreach ($xmlElements as $element) {
            $parsingResult = $element::parseXmlString($xmlTagString);
            if (! $parsingResult->isSuccess()) {
                $parserErrorBag->add($parsingResult->getError());
            } else {
                $xmlElementsBag[] = $parsingResult->getData();
            }
        }

        if (count($parserErrorBag->validationErrors) > 0) {
            return Result::makeFailure(
                $parserErrorBag->resolve()
            );
        }

        return Result::makeSuccess(
            new self(
                $tagValue,
                $xmlTagString,
                ...$xmlElementsBag
            )
        );
    }

    public static function create(string $tagValue = '', array $elements = [], array $attributes = []): Result
    {
        // TODO Verificar se tagValue esta vazio
        // TODO Verificar se attributes esta vazio
        // TODO Verificar se todas as tags obrigatorias estao presentes

        throw new Exception('Must be implemented');
    }
}
