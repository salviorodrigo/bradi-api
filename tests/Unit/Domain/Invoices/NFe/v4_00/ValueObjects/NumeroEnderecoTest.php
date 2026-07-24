<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroEndereco;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('NumeroEndereco', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\NumeroEndereco';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new NumeroEndereco('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(NumeroEndereco::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('nro');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'nro';
                $element->value = $candidate;
                $numeroEndereco = new NumeroEndereco('parentTag');
                $sut = new ReflectionMethod($numeroEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($numeroEndereco, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard_number' => '123',
                'alphanumeric' => '100-A',
                'literal' => '10',
                'minimum' => '1',
                'maximum' => 'STRING WITH SIXTY CHARACTERS STRING WITH SIXTY CHARACTERS AB',
                'with_spaces' => 'KM 45 BLOCO B',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = 'nro';
                $element->value = '';
                $numeroEndereco = new NumeroEndereco('parentTag');
                $sut = new ReflectionMethod($numeroEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($numeroEndereco, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'nro';
                $element->value = $candidate;
                $numeroEndereco = new NumeroEndereco('parentTag');
                $sut = new ReflectionMethod($numeroEndereco, 'validateTagValue');
                $sutResponse = $sut->invoke($numeroEndereco, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_long' => 'STRING WITH SIXTY ONE CHARACTERS STRING WITH SIXTY ONE ABCDEF',
                'leading_space' => ' 123',
                'trailing_space' => '123 ',
                'double_spaces' => '12  34',
            ]);
        });
    });
});
