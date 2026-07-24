<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoSituacaoTributaria', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoSituacaoTributaria';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoSituacaoTributaria('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoSituacaoTributaria::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('CST');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid CST codes', function (string $candidate) {
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'tributada_integralmente' => '00',
                'tributavel_aliquota_basica' => '01',
                'substituicao_tributaria' => '05',
                'isenta' => '40',
                'outras_operacoes' => '99',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '0',
                'too_long' => '100',
            ]);

            test('Should fail if non-numeric value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'alphabetic' => 'AA',
            ]);

            test('Should fail if value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading_space' => ' 00',
                'trailing_space' => '00 ',
                'middle_space' => '0 0',
            ]);

            test('Should fail if out of range code is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CST';
                $element->value = $candidate;
                $codigoSituacaoTributaria = new CodigoSituacaoTributaria('parentTag');
                $sut = new ReflectionMethod($codigoSituacaoTributaria, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoSituacaoTributaria, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'eleven' => '11',
                'forty_two' => '42',
                'eighty' => '80',
            ]);
        });
    });
});
