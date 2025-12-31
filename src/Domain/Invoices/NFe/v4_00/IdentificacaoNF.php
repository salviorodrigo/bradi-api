<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        5
 * ID       B01
 * Campo    ide
 * Desc     Informações de identificação da NF-e
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
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunFG;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\DataHoraEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdDestino;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndFinal;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Mod;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NatOp;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoEmissao;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoNF;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElement;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElementsGroup;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use Exception;

final class IdentificacaoNF extends DFeElementsGroup
{
    public static string $tagName = 'ide';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString,
        public readonly CodigoUF $cUF,
        public readonly CodigoNF $cNF,
        public readonly NatOp $natOp,
        public readonly Mod $mod,
        public readonly Serie $serie,
        public readonly NumeroNF $nNF,
        public readonly DataHoraEmissao $dhEmi,
        public readonly TipoNF $tpNF,
        public readonly IdDestino $idDest,
        public readonly CodigoMunFG $cMunFG,
        public readonly TipoEmissao $tpEmis,
        public readonly TipoAmbiente $tpAmb,
        public readonly FinalidadeNF $finNFe,
        public readonly IndFinal $indFinal
    ) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
            new RequiredTagValidator(self::$tagName),
            new RequiredTagValidator('cUF'),
            new RequiredTagValidator('cNF'),
            new RequiredTagValidator('natOp'),
            new RequiredTagValidator('mod'),
            new RequiredTagValidator('serie'),
            new RequiredTagValidator('nNF'),
            new RequiredTagValidator('dhEmi'),
            new RequiredTagValidator('tpNF'),
            new RequiredTagValidator('idDest'),
            new RequiredTagValidator('cMunFG'),
            new RequiredTagValidator('tpImp'),
            new RequiredTagValidator('tpEmis'),
            new RequiredTagValidator('cDV'),
            new RequiredTagValidator('tpAmb'),
            new RequiredTagValidator('finNFe'),
            new RequiredTagValidator('indFinal'),
            new RequiredTagValidator('indPres'),
            new RequiredTagValidator('procEmi'),
            new RequiredTagValidator('verProc'),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if (! $validationServiceResponse->isSuccess()) {
            return $validationServiceResponse;
        }

        $xmlTagString = self::xmlParser()->getTag($rawData, self::$tagName);
        $tagValue = self::xmlParser()->getTagValue($xmlTagString, self::$tagName);
        $validationValueResponse = self::validateTagValue($tagValue);

        if (! $validationValueResponse->isSuccess()) {
            return $validationValueResponse;
        }

        $xmlElements = [
            CodigoUF::class,
            CodigoNF::class,
            NatOp::class,
            Mod::class,
            Serie::class,
            NumeroNF::class,
            DataHoraEmissao::class,
            TipoNF::class,
            IdDestino::class,
            CodigoMunFG::class,
            TipoEmissao::class,
            TipoAmbiente::class,
            FinalidadeNF::class,
            IndFinal::class,
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

        $mod = array_find($xmlElementsBag, function (DFeElement $xmlElement) {
            return is_a($xmlElement, Mod::class);
        });

        if ($mod->value == '55') {
            $validationService = new ValidationService([
                new RequiredTagValidator('dhSaiEnt'),
            ]);
            $validationServiceResponse = $validationService->verify($rawData);
            if (! $validationServiceResponse->isSuccess()) {
                return $validationServiceResponse;
            }
        }

        $tpEmis = array_find($xmlElementsBag, function (DFeElement $xmlElement) {
            return is_a($xmlElement, TipoEmissao::class);
        });

        if ($tpEmis->value != '1') {
            $validationService = new ValidationService([
                new RequiredTagValidator('dhCont'),
                new RequiredTagValidator('xJust'),
            ]);
            $validationServiceResponse = $validationService->verify($rawData);
            if (! $validationServiceResponse->isSuccess()) {
                return $validationServiceResponse;
            }
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
