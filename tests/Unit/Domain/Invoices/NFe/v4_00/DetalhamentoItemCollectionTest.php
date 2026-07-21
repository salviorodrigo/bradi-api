<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoItem;
use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoItemCollection;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DetalhamentoItemCollection', function () {
    test('Should succeed if detalhamentoItem$detalhamentoItem is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\DetalhamentoItemCollection';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if DetalhamentoItemCollection extends DFeElementCollection', function () {
        $sut = new DetalhamentoItemCollection;
        expect(is_subclass_of($sut, DFeElementCollection::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('BASE_CLASS', function () {
            test('Should be a DetalhamentoItem::class', function () {
                $reflection = new ReflectionClass(DetalhamentoItemCollection::class);
                $reflectedProperty = $reflection->getConstant('BASE_CLASS');
                expect($reflectedProperty)->toBe(DetalhamentoItem::class);
            });
        });
    });

    describe('methods', function () {
        describe('validateCollection', function () {
            test('Should succeed if a valid collection of DetalhamentoItem elements is provided', function () {
                $xmlString = '<root><det nItem="1"></det><det nItem="2"></det><det nItem="3"></det></root>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $detalhamentoItem = new DetalhamentoItemCollection($xmlElement->name);
                $sut = new ReflectionMethod($detalhamentoItem, 'validateCollection');
                $sutResponse = $sut->invoke($detalhamentoItem, $xmlElement->children->records);
                expect($sutResponse->isSuccess())->toBeTrue();
            });
        });
    });
});
