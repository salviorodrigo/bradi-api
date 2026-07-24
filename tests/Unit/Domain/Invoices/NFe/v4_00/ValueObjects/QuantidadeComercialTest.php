<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\QuantidadeComercial;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('QuantidadeComercial', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\QuantidadeComercial';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new QuantidadeComercial('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(QuantidadeComercial::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('qCom');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid decimals', function (string $candidate) {
                $element = new Element;
                $element->name = 'qCom';
                $element->value = $candidate;
                $quantidade = new QuantidadeComercial('parentTag');
                $sut = new ReflectionMethod($quantidade, 'validateTagValue');
                $sutResponse = $sut->invoke($quantidade, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '10',
                'partial' => '125.4567',
                'minimum' => '0.0001',
                'maximum' => '99999999999.9999',
            ]);

            test('Should fail if value is empty', function () {
                $element = new Element;
                $element->name = 'qCom';
                $element->value = '';
                $quantidade = new QuantidadeComercial('parentTag');
                $sut = new ReflectionMethod($quantidade, 'validateTagValue');
                $sutResponse = $sut->invoke($quantidade, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'qCom';
                $element->value = $candidate;
                $quantidade = new QuantidadeComercial('parentTag');
                $sut = new ReflectionMethod($quantidade, 'validateTagValue');
                $sutResponse = $sut->invoke($quantidade, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading_zeros' => '010',
                'comma_decimal' => '10,50',
                'too_many_decimals' => '10.12345',
                'too_many_digits' => '123456789012',
                'alphabetic' => '10UN',
                'leading_space' => ' 10',
                'trailing_space' => '10 ',
                'middle_space' => '1 000',
            ]);
        });
    });
});
