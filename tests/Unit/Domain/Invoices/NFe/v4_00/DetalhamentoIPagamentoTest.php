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

        describe('$indPag', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoPagamento;
                expect($sut)->toHaveProperty('indPag');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('indPag');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('indPag');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });

        describe('$tPag', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoPagamento;
                expect($sut)->toHaveProperty('tPag');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('tPag');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('tPag');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$vPag', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoPagamento;
                expect($sut)->toHaveProperty('vPag');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('vPag');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be required', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('vPag');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeFalse();
            });
        });

        describe('$card', function () {
            test('Should be declared', function () {
                $sut = new DetalhamentoPagamento;
                expect($sut)->toHaveProperty('card');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('card');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(DetalhamentoPagamento::class);
                $reflectedProperty = $reflection->getProperty('card');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
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
                $xmlString = '<detPag><tPag/><vPag/></detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags are provided', function () {
                $xmlString = '<detPag><indPag/><tPag/><vPag/><card/></detPag>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new DetalhamentoPagamento;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if unallowed tag is provided', function () {
                $xmlString = '<detPag><unallowed/><indPag/><tPag/><vPag/><card/>/detPag>';
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
