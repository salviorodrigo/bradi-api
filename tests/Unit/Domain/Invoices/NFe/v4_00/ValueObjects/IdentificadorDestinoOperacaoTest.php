<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\IdentificadorDestinoOperacao;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('IdentificadorDestinoOperacao', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\IdentificadorDestinoOperacao';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new IdentificadorDestinoOperacao('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                expect(IdentificadorDestinoOperacao::FIELD_NAME)->toBe('idDest');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagAttributes', function () {
            test('Should fail if some attribute is provided', function () {
                $targetClass = new IdentificadorDestinoOperacao('parentTag');
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
                $targetClass = new IdentificadorDestinoOperacao('parentTag');
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
            test('Should succeed with valid numeric values', function (string $candidate) {
                $element = new Element;
                $element->name = IdentificadorDestinoOperacao::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IdentificadorDestinoOperacao('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'one' => '1',
                'two' => '2',
                'three' => '3',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = IdentificadorDestinoOperacao::FIELD_NAME;
                $element->value = '';
                $instance = new IdentificadorDestinoOperacao('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = IdentificadorDestinoOperacao::FIELD_NAME;
                $element->value = $candidate;
                $instance = new IdentificadorDestinoOperacao('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'zero' => '0',
                'four' => '4',
                'alphabetic' => 'a',
                'leading_space' => ' 1',
                'trailing_space' => '1 ',
            ]);
        });
    });
});
