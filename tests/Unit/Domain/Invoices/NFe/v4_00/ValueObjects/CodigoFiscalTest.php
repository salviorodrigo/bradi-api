<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoFiscal', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoFiscal('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoFiscal::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('CFOP');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new CodigoFiscal('parentTag');
                $fieldName = (new ReflectionClass($targetClass))->getConstant('FIELD_NAME');
                $xmlString = "<{$fieldName} attribute=\"aValue\"></{$fieldName}>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new ReflectionMethod($targetClass, 'validateTagAttributes');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagElements', function () {
            test('Should fail if some element is provided', function () {
                $targetClass = new CodigoFiscal('parentTag');
                $fieldName = (new ReflectionClass($targetClass))->getConstant('FIELD_NAME');
                $xmlString = "<{$fieldName}><unallowed/></{$fieldName}>";
                $xmlElement = new Element;
                $xmlElement->parse($xmlString);
                $sut = new ReflectionMethod($targetClass, 'validateTagElements');
                $sutResponse = $sut->invoke($targetClass, $xmlElement);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });

        describe('validateTagValue', function () {
            test('Should succeed with valid CFOP codes', function (string $candidate) {
                $element = new Element;
                $element->name = 'CFOP';
                $element->value = $candidate;
                $codigoFiscal = new CodigoFiscal('parentTag');
                $sut = new ReflectionMethod($codigoFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoFiscal, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'intrastate' => '5102',
                'interstate' => '6102',
                'exterior' => '7102',
                'purchase' => '1102',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'CFOP';
                $element->value = $candidate;
                $codigoFiscal = new CodigoFiscal('parentTag');
                $sut = new ReflectionMethod($codigoFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoFiscal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'CFOP';
                $element->value = $candidate;
                $codigoFiscal = new CodigoFiscal('parentTag');
                $sut = new ReflectionMethod($codigoFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoFiscal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '510',
                'too_long' => '51021',
            ]);

            test('Should fail if non-numeric or formatted value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CFOP';
                $element->value = $candidate;
                $codigoFiscal = new CodigoFiscal('parentTag');
                $sut = new ReflectionMethod($codigoFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoFiscal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '5.102',
                'alphanumeric' => '51A0',
            ]);

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CFOP';
                $element->value = $candidate;
                $codigoFiscal = new CodigoFiscal('parentTag');
                $sut = new ReflectionMethod($codigoFiscal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoFiscal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 5102',
                'trailing space' => '5102 ',
                'middle space' => '51 02',
            ]);
        });
    });
});
