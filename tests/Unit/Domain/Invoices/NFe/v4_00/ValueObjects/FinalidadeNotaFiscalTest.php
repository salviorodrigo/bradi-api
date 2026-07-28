<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\FinalidadeNotaFiscal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('FinalidadeNotaFiscal', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\FinalidadeNotaFiscal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new FinalidadeNotaFiscal('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(FinalidadeNotaFiscal::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('finNFe');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new FinalidadeNotaFiscal('parentTag');
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
                $targetClass = new FinalidadeNotaFiscal('parentTag');
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
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'finNFe';
                $element->value = $candidate;
                $instance = new FinalidadeNotaFiscal('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'normal' => '1',
                'complementary' => '2',
                'adjustment' => '3',
                'return' => '4',
            ]);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'finNFe';
                $element->value = $candidate;
                $instance = new FinalidadeNotaFiscal('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'leading_space' => ' 1',
                'trailing_space' => '1 ',
                'alphabetic' => 'A',
                'out_of_range_zero' => '0',
                'out_of_range_five' => '5',
            ]);
        });
    });
});
