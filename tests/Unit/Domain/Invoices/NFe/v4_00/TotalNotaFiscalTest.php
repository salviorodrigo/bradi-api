<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\TotalNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('TotalNotaFiscal', function () {
    test('Should succeed if TotalNotaFiscal is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\TotalNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if TotalNotaFiscal extends DFeElement', function () {
        $sut = new TotalNotaFiscal;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('$ICMSTot', function () {
            test('Should be declared', function () {
                $sut = new TotalNotaFiscal;
                expect($sut)->toHaveProperty('ICMSTot');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ICMSTot');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ICMSTot');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$ISSQNtot', function () {
            test('Should be declared', function () {
                $sut = new TotalNotaFiscal;
                expect($sut)->toHaveProperty('ISSQNtot');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ISSQNtot');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('ISSQNtot');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();

        describe('$retTrib', function () {
            test('Should be declared', function () {
                $sut = new TotalNotaFiscal;
                expect($sut)->toHaveProperty('retTrib');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('retTrib');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(TotalNotaFiscal::class);
                $reflectedProperty = $reflection->getProperty('retTrib');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        })->skip();
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<total attribute="value"/>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new TotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags are provided', function () {
                $xmlString = '<total><ICMSTot/></total>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new TotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if all tags is provided', function () {
                $xmlString = '<total><ICMSTot/><ISSQNtot/><retTrib/></total>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new TotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<total>value</total>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $targetClass = new TotalNotaFiscal;
                $sut = new ReflectionMethod($targetClass, 'validateTagValue');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
