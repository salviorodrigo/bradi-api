<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NaturezaOperacao;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('NaturezaOperacao', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\NaturezaOperacao';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new NaturezaOperacao('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(NaturezaOperacao::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('natOp');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new NaturezaOperacao('parentTag');
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
                $targetClass = new NaturezaOperacao('parentTag');
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
            test('Should succeed in border cases', function (string $candidate) {
                $element = new Element;
                $element->name = 'natOp';
                $element->value = $candidate;
                $naturezaOperacao = new NaturezaOperacao('parentTag');
                $sut = new ReflectionMethod($naturezaOperacao, 'validateTagValue');
                $sutResponse = $sut->invoke($naturezaOperacao, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'min_length' => 'A',
                'max_length' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'natOp';
                $element->value = $candidate;
                $naturezaOperacao = new NaturezaOperacao('parentTag');
                $sut = new ReflectionMethod($naturezaOperacao, 'validateTagValue');
                $sutResponse = $sut->invoke($naturezaOperacao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value is too long', function () {
                $candidate = 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF';
                $element = new Element;
                $element->name = 'natOp';
                $element->value = $candidate;
                $naturezaOperacao = new NaturezaOperacao('parentTag');
                $sut = new ReflectionMethod($naturezaOperacao, 'validateTagValue');
                $sutResponse = $sut->invoke($naturezaOperacao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a text value with invalid spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'natOp';
                $element->value = $candidate;
                $naturezaOperacao = new NaturezaOperacao('parentTag');
                $sut = new ReflectionMethod($naturezaOperacao, 'validateTagValue');
                $sutResponse = $sut->invoke($naturezaOperacao, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' STANDARD',
                'trailing space' => 'STANDARD ',
                'nested spaces' => 'STANDARD  STANDARD',
            ]);
        });
    });
});
