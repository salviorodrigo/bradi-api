<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Invoices\NFe\v4_00\IdentificacaoNF;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal;
use BradiNfeApi\Domain\Invoices\Templates\DFeElement;

describe('InformacoesNotaFiscal', function () {
    describe('::class', function () {
        test('Should succeed if InformacoesNotaFiscal is declared', function () {
            expect(class_exists('BradiNfeApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal'))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal extends DFeElement', function () {
            expect(is_subclass_of(InformacoesNotaFiscal::class, DFeElement::class))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal has $ide attribute', function () {
            $informacoesNotaFiscal = new InformacoesNotaFiscal;
            expect(property_exists($informacoesNotaFiscal, 'ide'))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal::$ide is a IdentificacaoNF::class', function () {
            $informacoesNotaFiscal = new InformacoesNotaFiscal;
            expect($informacoesNotaFiscal->ide)->toBeInstanceOf(IdentificacaoNF::class);
        });
    });
});
