<?php

declare(strict_types=1);

/**
 * MOC      7.0
 * #        62
 * ID       E01
 * Campo    dest
 * Desc     Identificação do destinatario da NF-e
 * Tam
 * OBS:
 * Grupo Obrigatório para a NF-e (modelo 55).
 */

namespace BradiNfeApi\Domain\Invoices\NFe\v4_00;

use BradiNfeApi\Common\Exceptions\ValidationErrorBag;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\OptionalOrValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorIEDestinatario;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\InscricaoEstadual;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Nome;
use BradiNfeApi\Domain\Invoices\Protocols\DFeElementsGroup;
use BradiNfeApi\Domain\Invoices\Validators\AtLeastOneTagValidator;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;
use Exception;

final class Destinatario extends DFeElementsGroup
{
    public static string $tagName = 'dest';

    private function __construct(
        public readonly string $value,
        public readonly string $xmlString,
        public readonly CadastroPJ $CNPJ,
        public readonly CadastroPF $CPF,
        public readonly Nome $xNome,
        public readonly EnderecoDestinatario $endDest,
        public readonly IndicadorIEDestinatario $indIEDest,
        public readonly InscricaoEstadual $IE,

    ) {}

    public static function parseXmlString(mixed $rawData): Result
    {
        $validationService = new OptionalOrValidationService([
            new IsStringValidator(self::$tagName),
            new NotNullValidator(self::$tagName),
            new IsXmlTagValidator(self::$tagName),
            new AtLeastOneTagValidator(self::$tagName, ['CNPJ', 'CPF', 'idEstrangeiro']),
            new RequiredTagValidator('indIEDest'),
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

        $xmlElements = [
            CadastroPJ::class,
            CadastroPF::class,
            Nome::class,
            EnderecoDestinatario::class,
            IndicadorIEDestinatario::class,
            InscricaoEstadual::class,
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
        // TODO Validar se possui CPF ou CNPJ
        // TODO Validar se possui Nome Caso Mod for 55
        // TODO Validar IE de acordo com tipo de Indicador de IE

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
