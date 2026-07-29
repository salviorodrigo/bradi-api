<?php

declare(strict_types=1);

use BradiApi\Domain\Invoices\NFe\v4_00\InformacoesPagamento;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('InformacoesPagamento', function () {
    test('Should succeed if InformacoesPagamento is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\InformacoesPagamento';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if InformacoesPagamento extends DFeElement', function () {
        $sut = new InformacoesPagamento;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(InformacoesPagamento::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('pag');
            });
        });

        describe('$detPag', function () {
            test('Should be declared', function () {
                $sut = new InformacoesPagamento;
                expect($sut)->toHaveProperty('detPag');
            });

            test('Should be a subclass of DFeElementCollection::class', function () {
                $reflection = new ReflectionClass(InformacoesPagamento::class);
                $reflectedProperty = $reflection->getProperty('detPag');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElementCollection::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(InformacoesPagamento::class);
                $reflectedProperty = $reflection->getProperty('detPag');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vTroco', function () {
            test('Should be declared', function () {
                $sut = new InformacoesPagamento;
                expect($sut)->toHaveProperty('vTroco');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(InformacoesPagamento::class);
                $reflectedProperty = $reflection->getProperty('vTroco');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(InformacoesPagamento::class);
                $reflectedProperty = $reflection->getProperty('vTroco');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<pag attribute="value"></pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<pag><detPag/></pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeFalse();
            });

            test('Should succeed if all available tags are provided', function () {
                $xmlString = '<pag><detPag/><vTroco/></pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeFalse();
            });

            test('Should fail if detPag tag is missing', function () {
                $xmlString = '<pag><vTroco/></pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<pag><unallowed/><detPag/><vTroco/></pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<pag>value</pag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new InformacoesPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
