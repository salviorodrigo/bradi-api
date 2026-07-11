<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Invoices\NFe\v4_00\Destinatario;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\DetalhamentoItem;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Emitente;
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
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $sut = $reflection->getProperty('ide');

            expect($sut->getType()->getName())->toBe(IdentificacaoNF::class);

        });

        test('Should succeed if InformacoesNotaFiscal has $emit attribute', function () {
            $informacoesNotaFiscal = new InformacoesNotaFiscal;
            expect(property_exists($informacoesNotaFiscal, 'emit'))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal::$emit is a Emitente::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $sut = $reflection->getProperty('emit');

            expect($sut->getType()->getName())->toBe(Emitente::class);
        });

        test('Should succeed if InformacoesNotaFiscal has $dest attribute', function () {
            $informacoesNotaFiscal = new InformacoesNotaFiscal;
            expect(property_exists($informacoesNotaFiscal, 'dest'))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal::$dest is a Destinatario::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $sut = $reflection->getProperty('dest');

            expect($sut->getType()->getName())->toBe(Destinatario::class);
        });

        test('Should succeed if InformacoesNotaFiscal has $det attribute', function () {
            $informacoesNotaFiscal = new InformacoesNotaFiscal;
            expect(property_exists($informacoesNotaFiscal, 'det'))->toBeTrue();
        });

        test('Should succeed if InformacoesNotaFiscal::$det is a DetalhamentoItem::class', function () {
            $reflection = new ReflectionClass(InformacoesNotaFiscal::class);
            $sut = $reflection->getProperty('det');

            expect($sut->getType()->getName())->toBe(DetalhamentoItem::class);
        });
    });
});
