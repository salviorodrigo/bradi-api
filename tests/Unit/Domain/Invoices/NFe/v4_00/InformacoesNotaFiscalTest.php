<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;

describe('InformacoesNotaFiscal', function () {
    describe('::class', function () {
        test('Should succeed if InformacoesNotaFiscal is declared', function () {
            $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
            $sut = $nameSpace . '\\InformacoesNotaFiscal';
            expect(class_exists($sut))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal extends DFeElement', function () {
            $sut = new InformacoesNotaFiscal;
            expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal has $ide element', function () {
            $sut = new InformacoesNotaFiscal;
            expect($sut)->toHaveProperty('ide');
        });

        test('Should succeed if $ide is a subclass of DFeElement::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $ide = $reflection->getProperty('ide');
            $sut = $ide->getType();
            expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal has $emit element', function () {
            $sut = new InformacoesNotaFiscal;
            expect($sut)->toHaveProperty('emit');
        });

        test('Should succeed if $emit is a subclass of DFeElement::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $emit = $reflection->getProperty('emit');
            $sut = $emit->getType();
            expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal has $dest element', function () {
            $sut = new InformacoesNotaFiscal;
            expect($sut)->toHaveProperty('dest');
        });

        test('Should succeed if $dest is a subclass of DFeElement::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $dest = $reflection->getProperty('dest');
            $sut = $dest->getType();
            expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal has $det element', function () {
            $sut = new InformacoesNotaFiscal;
            expect($sut)->toHaveProperty('det');
        });

        test('Should succeed if $det is a subclass of DFeElement::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $det = $reflection->getProperty('det');
            $sut = $det->getType();

            expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
        });
    });
});
