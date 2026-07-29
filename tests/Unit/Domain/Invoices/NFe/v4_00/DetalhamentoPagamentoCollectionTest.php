<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoPagamento;
use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoPagamentoCollection;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DetalhamentoPagamentoCollection', function () {
    test('Should succeed if DetalhamentoPagamento is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\DetalhamentoPagamentoCollection';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if DetalhamentoPagamentoCollection extends DFeElementCollection', function () {
        $sut = new DetalhamentoPagamentoCollection;
        expect(is_subclass_of($sut, DFeElementCollection::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('BASE_CLASS', function () {
            test('Should be a DetalhamentoPagamento::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamentoCollection::class);
                $reflectedProperty = $reflection->getConstant('BASE_CLASS');
                expect($reflectedProperty)->toBe(DetalhamentoPagamento::class);
            });
        });

        describe('FIELD_NAME', function () {
            test('Should be a DetalhamentoPagamento::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamentoCollection::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('detPag');
            });
        });
    });

    describe('methods', function () {
        describe('validateCollection', function () {
            test('Should succeed if a valid collection of DetalhamentoPagamento elements is provided', function () {
                $xmlString = '<root><detPag nItem="1"></detPag><detPag nItem="2"></detPag><detPag nItem="3"></detPag></root>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamentoCollection($xmlElement->name);
                $sut = new ReflectionMethod($targetClass, 'validateCollection');
                $sutResponse = $sut->invoke($targetClass, $xmlElement->children->records);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if a collection with more than 100 elements is provided', function () {
                $xmlString = '<root>';
                for ($i = 1; $i <= 101; $i++) {
                    $xmlString .= '<detPag nItem="' . $i . '"></detPag>';
                }
                $xmlString .= '</root>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamentoCollection($xmlElement->name);
                $sut = new ReflectionMethod($targetClass, 'validateCollection');
                $sutResponse = $sut->invoke($targetClass, $xmlElement->children->records);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
