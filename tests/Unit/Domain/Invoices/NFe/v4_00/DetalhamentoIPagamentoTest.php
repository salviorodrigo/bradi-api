<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\DetalhamentoPagamento;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('DetalhamentoPagamento', function () {
    test('Should succeed if DetalhamentoPagamento$targetClass is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\DetalhamentoPagamento';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if DetalhamentoPagamento extends DFeElement', function () {
        $sut = new DetalhamentoPagamento;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('detPag');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if any attribute is provided', function () {
                $xmlString = '<detPag attribute="aValue"></detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<detPag><detPag></detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<detPag><unallowed></unallowed></detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            })->skip();
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<detPag>value</detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
