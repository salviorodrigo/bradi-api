<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSubstituicaoTributaria;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoSubstituicaoTributaria', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoSubstituicaoTributaria';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoSubstituicaoTributaria('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoSubstituicaoTributaria::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('CEST');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid CEST code', function () {
                $candidate = '0100100';
                $element = new Element;
                $element->name = 'CEST';
                $element->value = $candidate;
                $codigoSubstituicaoTributaria = new CodigoSubstituicaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSubstituicaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSubstituicaoTributaria, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'CEST';
                $element->value = $candidate;
                $codigoSubstituicaoTributaria = new CodigoSubstituicaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSubstituicaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSubstituicaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEST';
                $element->value = $candidate;
                $codigoSubstituicaoTributaria = new CodigoSubstituicaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSubstituicaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSubstituicaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '010010',
                'too_long' => '01001001',
            ]);

            test('Should fail if non-numeric or formatted value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEST';
                $element->value = $candidate;
                $codigoSubstituicaoTributaria = new CodigoSubstituicaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSubstituicaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSubstituicaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '01.001-00',
                'alphanumeric' => '01A00100',
            ]);

            test('Should fail if value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEST';
                $element->value = $candidate;
                $codigoSubstituicaoTributaria = new CodigoSubstituicaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSubstituicaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSubstituicaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading_space' => ' 0100100',
                'trailing_space' => '0100100 ',
                'middle_space' => '010 0100',
            ]);
        });
    });
});
