<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorUnitarioComercial;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('ValorUnitarioComercial', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\ValorUnitarioComercial';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new ValorUnitarioComercial('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(ValorUnitarioComercial::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('vUnCom');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid decimals', function (string $candidate) {
                $element = new Element;
                $element->name = 'vUnCom';
                $element->value = $candidate;
                $valor = new ValorUnitarioComercial('parentTag');
                $sut = new ReflectionMethod($valor, 'validateTagValue');
                $sutResponse = $sut->invoke($valor, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '10.0000000000',
                'partial' => '125.1234567890',
                'minimum' => '0.0000000001',
                'maximum' => '99999999999.9999999999',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = 'vUnCom';
                $element->value = '';
                $valor = new ValorUnitarioComercial('parentTag');
                $sut = new ReflectionMethod($valor, 'validateTagValue');
                $sutResponse = $sut->invoke($valor, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'vUnCom';
                $element->value = $candidate;
                $valor = new ValorUnitarioComercial('parentTag');
                $sut = new ReflectionMethod($valor, 'validateTagValue');
                $sutResponse = $sut->invoke($valor, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_many_decimals' => '10.11111111111',
                'comma_decimal' => '10,50',
                'alphabetic' => '10A',
                'leading_space' => ' 10.1234567890',
                'trailing_space' => '10.1234567890 ',
                'middle_space' => '10 .1234567890',
                'negative' => '-10.1234567890',
            ]);
        });
    });
});
