<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\TipoAmbiente;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('TipoAmbiente', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\TipoAmbiente';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new TipoAmbiente('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(TipoAmbiente::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('tpAmb');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new TipoAmbiente('parentTag');
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
                $targetClass = new TipoAmbiente('parentTag');
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
            test('Should succeed in valid options', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'production' => '1',
                'homologation' => '2',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is out of range', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'zero' => '0',
                'three' => '3',
            ]);

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'P';
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1',
                'trailing space' => '2 ',
            ]);

            test('Should fail if value has invalid length', function () {
                $candidate = '01';
                $element = new Element;
                $element->name = 'tpAmb';
                $element->value = $candidate;
                $tipoAmbiente = new TipoAmbiente('parentTag');
                $sut = new ReflectionMethod($tipoAmbiente, 'validateTagValue');
                $sutResponse = $sut->invoke($tipoAmbiente, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
