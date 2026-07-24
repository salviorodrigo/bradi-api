<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoNF', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\CodigoNF';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeElement', function () {
        $sut = new CodigoNF('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoNF::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('cNF');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in valid options', function () {
                $candidate = '40285167';
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '4028516',
                'too_long' => '402851678',
            ]);

            test('Should fail if non-numeric or formatted value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '40.285.167',
                'alphanumeric' => '4028516A',
            ]);

            test('Should fail if repeated digits or sequential digits are provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'repeated digits' => '11111111',
                'sequential digits' => '12345678',
            ]);

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cNF';
                $element->value = $candidate;
                $codigoNF = new CodigoNF('parentTag');
                $sut = new ReflectionMethod($codigoNF, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoNF, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 40285167',
                'trailing space' => '40285167 ',
                'middle space' => '402 85167',
            ]);
        });
    });
});
