<?php

declare(strict_types=1);
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\AliquotaICMS;
use BradiApi\Domain\Invoices\Templates\DFeElement;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('AliquotaICMS', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\AliquotaICMS';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeelement', function () {
        $sut = new AliquotaICMS('parentTag');
        expect(is_subclass_of($sut, DFeElement::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(AliquotaICMS::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('pICMS');
            });
        });
    });

    describe('methods', function () {
        describe('validateTagValue', function () {
            test('Should succeed in border cases', function (string $candidate) {
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '7.60',
                'with_decimals' => '12.3456',
                'min' => '0',
                'max' => '100',
            ]);

            test('Should fail if less than 0 is provided', function () {
                $candidate = '-0.01';
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if greater than 100 is provided', function () {
                $candidate = '100.01';
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if more than 4 decimal places is provided', function () {
                $candidate = '12.34567';
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'abc';
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if a numeric value with spaces is provided', function ($candidate) {
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 12.34',
                'trailing space' => '12.34 ',
                'leading and trailing space' => ' 12.34 ',
            ]);

            test('Should fail if a value with comma as decimal separator is provided', function () {
                $candidate = '12,34';
                $element = new Element;
                $element->name = 'pICMS';
                $element->value = $candidate;
                $aliquotaICMS = new AliquotaICMS('parentTag');
                $sut = new ReflectionMethod($aliquotaICMS, 'validateTagValue');
                $sutResponse = $sut->invoke($aliquotaICMS, $element);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
