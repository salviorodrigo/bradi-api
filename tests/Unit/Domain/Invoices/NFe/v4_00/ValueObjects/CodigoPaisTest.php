<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPais;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoPais', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\CodigoPais';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoPais('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(CodigoPais::FIELD_NAME)->toBe('cPais');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new CodigoPais('parentTag');
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
                $targetClass = new CodigoPais('parentTag');
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
            test('Should succeed in valid options', function () {
                $element = new Element;
                $element->name = CodigoPais::FIELD_NAME;
                $element->value = '1058';
                $codigoPais = new CodigoPais('parentTag');
                $sut = new ReflectionMethod($codigoPais, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPais, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = CodigoPais::FIELD_NAME;
                $element->value = '';
                $codigoPais = new CodigoPais('parentTag');
                $sut = new ReflectionMethod($codigoPais, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPais, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = CodigoPais::FIELD_NAME;
                $element->value = $candidate;
                $codigoPais = new CodigoPais('parentTag');
                $sut = new ReflectionMethod($codigoPais, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPais, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '105',
                'too_long' => '10589',
            ]);

            test('Should fail if non-numeric value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = CodigoPais::FIELD_NAME;
                $element->value = $candidate;
                $codigoPais = new CodigoPais('parentTag');
                $sut = new ReflectionMethod($codigoPais, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPais, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '1.058',
                'alphanumeric' => '10A8',
            ]);

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = CodigoPais::FIELD_NAME;
                $element->value = $candidate;
                $codigoPais = new CodigoPais('parentTag');
                $sut = new ReflectionMethod($codigoPais, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPais, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1058',
                'trailing space' => '1058 ',
                'middle space' => '10 58',
            ]);
        });
    });
});
