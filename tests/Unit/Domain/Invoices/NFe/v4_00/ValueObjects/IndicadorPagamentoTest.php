<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IndicadorPagamento;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IndicadorPagamento', function () {
    test('Should succeed if IndicadorPagamento::class is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\IndicadorPagamento';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if IndicadorPagamento extends DFeElement', function () {
        $sut = new IndicadorPagamento;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(IndicadorPagamento::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('indPag');
            });
        });
    });

    describe('methods', function () {
        describe('tagAttributesValidators', function () {
            test('Should fail if some attribute is provided', function () {
                $xmlString = '<indPag attribute="aValue"></indPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IndicadorPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should fail if some tag is provided', function () {
                $xmlString = '<indPag>aValue<xmlTag/></indPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IndicadorPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('tagValueValidators', function () {
            test('Should succeed if a valid value is provided', function ($candidate) {
                $xmlString = "<indPag>{$candidate}</indPag>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new IndicadorPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'Pagamento a vista' => '0',
                'Pagamento a prazo' => '1',
            ]);
        });
    });
});
