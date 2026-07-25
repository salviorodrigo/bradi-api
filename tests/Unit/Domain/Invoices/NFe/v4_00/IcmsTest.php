<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Invoices\NFe\v4_00\Icms;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\TestCase;

describe('Icms', function () {
    test('Should succeed if Icms is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00';
        $sut = $nameSpace . '\\Icms';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if Icms extends DFeElement', function () {
        $sut = new Icms;
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Icms;
    });

    describe('properties', function () {
        describe('$ICMS00', function () {
            test('Should be declared', function () {
                $sut = new Icms;
                expect($sut)->toHaveProperty('ICMS00');
            });

            test('Should be a subclass of DFeElement::class', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS00');
                $sut = $reflectedProperty->getType();
                expect((is_subclass_of($sut->getName(), DFeElement::class)))->toBeTrue();
            });

            test('Should be optional', function () {
                $reflection = new ReflectionClass(Icms::class);
                $reflectedProperty = $reflection->getProperty('ICMS00');
                $sut = $reflectedProperty->getType();
                expect($sut->allowsNull())->toBeTrue();
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if an attribute is provided', function () {
                $xmlString = '<ICMS attribute="value"><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagAttributes');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should succeed if all required tags is provided', function () {
                $xmlString = '<ICMS><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if ICMS00 tag isnt provided', function () {
                $xmlString = '<ICMS></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should succeed if an unallowed tag is provided', function () {
                $xmlString = '<ICMS><unallowed></unallowed><ICMS00></ICMS00></ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagElements');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isSuccess())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should fail if a value is provided', function () {
                $xmlString = '<ICMS>value</ICMS>';
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $icms = new Icms;
                $sut = new ReflectionMethod($icms, 'validateTagValue');
                $sutResponse = $sut->invoke($icms, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
            });
        });
    });
});
