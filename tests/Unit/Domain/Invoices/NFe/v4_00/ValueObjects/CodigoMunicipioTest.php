<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoMunicipio;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoMunicipio', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoMunicipio';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoMunicipio('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoMunicipio::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('cMun');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid municipality codes', function (string $candidate) {
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'sao_paulo_city' => '3550308',
                'alta_floresta_ro' => '1100015',
                'exterior' => '9999999',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'too_short' => '355030',
                'too_long' => '35503088',
            ]);

            test('Should fail if non-numeric or formatted value is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'masked' => '355.030-8',
                'alphanumeric' => '355A308',
            ]);

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 3550308',
                'trailing space' => '3550308 ',
                'middle space' => '355 308',
            ]);

            test('Should fail if invalid check digit is provided', function () {
                $candidate = '3304555';
                $element = new Element;
                $element->name = 'cMun';
                $element->value = $candidate;
                $codigoMunicipio = new CodigoMunicipio('parentTag');
                $sut = new ReflectionMethod($codigoMunicipio, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoMunicipio, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
