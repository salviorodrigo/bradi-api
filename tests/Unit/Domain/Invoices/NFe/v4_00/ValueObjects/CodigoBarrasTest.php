<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoBarras;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('CodigoBarras', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\\Domain\\Invoices\\NFe\\v4_00\\ValueObjects';
        $sut = $nameSpace . '\\CodigoBarras';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new CodigoBarras('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(CodigoBarras::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('cEAN');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed with valid barcode values', function (string $candidate) {
                $element = new Element;
                $element->name = 'cEAN';
                $element->value = $candidate;
                $codigoBarras = new CodigoBarras('parentTag');
                $sut = new ReflectionMethod($codigoBarras, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoBarras, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'without_gtin' => 'SEM GTIN',
                'gtin_8' => '12345670',
                'gtin_12' => '123456789012',
                'gtin_13' => '1234567890123',
                'gtin_14' => '12345678901234',
            ]);

            test('Should fail if value is empty', function () {
                $candidate = '';
                $element = new Element;
                $element->name = 'cEAN';
                $element->value = $candidate;
                $codigoBarras = new CodigoBarras('parentTag');
                $sut = new ReflectionMethod($codigoBarras, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoBarras, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail with invalid text', function (string $candidate) {
                $element = new Element;
                $element->name = 'cEAN';
                $element->value = $candidate;
                $codigoBarras = new CodigoBarras('parentTag');
                $sut = new ReflectionMethod($codigoBarras, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoBarras, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'without_gtin_lowercase' => 'sem gtin',
                'alphanumeric' => 'ABC123456789',
            ]);

            test('Should fail if value has invalid length', function (string $candidate) {
                $element = new Element;
                $element->name = 'cEAN';
                $element->value = $candidate;
                $codigoBarras = new CodigoBarras('parentTag');
                $sut = new ReflectionMethod($codigoBarras, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoBarras, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'length_7' => '1234567',
                'length_9' => '123456789',
                'length_11' => '12345678901',
                'length_15' => '123456789012345',
            ]);

            test('Should fail if value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'cEAN';
                $element->value = $candidate;
                $codigoBarras = new CodigoBarras('parentTag');
                $sut = new ReflectionMethod($codigoBarras, 'validateTagValue');
                $sutResponse = $sut->invoke($codigoBarras, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading_spaces' => ' 1234567890123',
                'trailing_spaces' => '1234567890123 ',
                'middle_spaces' => '123 4567890123',
            ]);
        });
    });
});
