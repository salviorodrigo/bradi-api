<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\ValorICMS;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('ValorICMS', function () {

    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\ValorICMS';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new ValorICMS('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(ValorICMS::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('vICMS');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in border cases', function (string $candidate) {
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '10.00',
                'with_cents' => '125.45',
                'zero' => '0.00',
                'max' => '9999999999999.99',
            ]);

            test('Should fail if less than 0 is provided', function () {
                $candidate = '-0.01';
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if greater than max is provided', function () {
                $candidate = '10000000000000.00';
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if more than 2 decimal places is provided', function () {
                $candidate = '10.123';
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if non-numeric value is provided', function () {
                $candidate = '10A';
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function (string $candidate) {
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 10',
                'trailing space' => '10 ',
                'middle space' => '1 000',
            ]);

            test('Should fail if a value with comma as decimal separator is provided', function () {
                $candidate = '10,50';
                $element = new Element;
                $element->name = 'vICMS';
                $element->value = $candidate;
                $valorICMS = new ValorICMS('parentTag');
                $sut = new ReflectionMethod($valorICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($valorICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
