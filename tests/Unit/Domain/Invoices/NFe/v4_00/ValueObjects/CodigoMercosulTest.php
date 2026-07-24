<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMercosul;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoMercosul', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoMercosul';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new CodigoMercosul('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoMercosul::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('NCM');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid values', function (string $candidate) {
                $element = new Element;
                $element->name = 'NCM';
                $element->value = $candidate;
                $instance = new CodigoMercosul('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with(['standard' => '01012100', 'service_or_no_product' => '00']);

            test('Should fail if value is invalid', function (string $candidate) {
                $element = new Element;
                $element->name = 'NCM';
                $element->value = $candidate;
                $instance = new CodigoMercosul('parentTag');
                $sut = new ReflectionMethod($instance, 'validateTagValue');
                $sutResponse = $sut->invoke($instance, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'empty' => '',
                'out_of_range_01' => '01',
                'out_of_range_10' => '10',
                'too_long_3' => '100',
                'too_long_9' => '123456789',
                'too_short_1' => '0',
                'too_short_7' => '1234567',
                'leading_space' => ' 01012100',
                'trailing_space' => '01012100 ',
                'middle_space' => '010 12100',
                'with_mask' => '0101.21.00',
                'alphabetic' => 'ABC12345',
            ]);
        });
    });
});
