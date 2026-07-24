<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoPostal;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoPostal', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\CodigoPostal';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoPostal('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoPostal::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('CEP');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in valid options', function () {
                $candidate = '12345678';
                $element = new Element;
                $element->name = 'CEP';
                $element->value = $candidate;
                $codigoPostal = new CodigoPostal('parentTag');
                $sut = new ReflectionMethod($codigoPostal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPostal, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'CEP';
                $element->value = $candidate;
                $codigoPostal = new CodigoPostal('parentTag');
                $sut = new ReflectionMethod($codigoPostal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPostal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEP';
                $element->value = $candidate;
                $codigoPostal = new CodigoPostal('parentTag');
                $sut = new ReflectionMethod($codigoPostal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPostal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '1234567',
                'too_long' => '123456789',
            ]);

            test('Should fail if non-numeric value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEP';
                $element->value = $candidate;
                $codigoPostal = new CodigoPostal('parentTag');
                $sut = new ReflectionMethod($codigoPostal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPostal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '12.345-678',
                'alphanumeric' => '12A4567B',
            ]);

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'CEP';
                $element->value = $candidate;
                $codigoPostal = new CodigoPostal('parentTag');
                $sut = new ReflectionMethod($codigoPostal, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoPostal, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 12345678',
                'trailing space' => '12345678 ',
                'middle space' => '123 45678',
            ]);
        });
    });
});
