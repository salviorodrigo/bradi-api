<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroItem;
use BradiApi\Domain\Invoices\Templates\DFeAttribute;
use BradiApi\Domain\Xml\ValueObjects\Attribute;

describe('NumeroItem', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\v4_00\ValueObjects';
        $sut = $nameSpace . '\\NumeroItem';
        expect(class_exists($sut))->toBeTrue();
    });

    test('Should succeed if extends DFeAttribute', function () {
        $sut = new NumeroItem('parentTag');
        expect(is_subclass_of($sut, DFeAttribute::class))->toBeTrue();
    });

    describe('properties', function () {
        describe('FIELD_NAME', function () {
            test('Should be set correctly', function () {
                $reflection = new ReflectionClass(NumeroItem::class);
                $reflectedProperty = $reflection->getConstant('FIELD_NAME');
                expect($reflectedProperty)->toBe('nItem');
            });
        });
    });

    describe('methods', function () {
        describe('validateAttributeValue', function () {
            test('Should succeed in border cases', function (string $candidate) {
                $attribute = new Attribute('nItem', $candidate, 'parentTag');
                $numeroItem = new NumeroItem('parentTag');
                $sut = new ReflectionMethod($numeroItem, 'validateAttributeValue');
                $sutResponse = $sut->invoke($numeroItem, $attribute);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail(json_encode($sutResponse->getError()));
                }

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'first occurence' => '1',
                'last occurence' => '990',
            ]);

            test('Should fail if zero is provided', function () {
                $candidate = '0';
                $attribute = new Attribute('nItem', $candidate, 'parentTag');
                $numeroItem = new NumeroItem('parentTag');
                $sut = new ReflectionMethod($numeroItem, 'validateAttributeValue');
                $sutResponse = $sut->invoke($numeroItem, $attribute);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if greater than 990 is provided', function () {
                $candidate = '991';
                $attribute = new Attribute('nItem', $candidate, 'parentTag');
                $numeroItem = new NumeroItem('parentTag');
                $sut = new ReflectionMethod($numeroItem, 'validateAttributeValue');
                $sutResponse = $sut->invoke($numeroItem, $attribute);
                expect($sutResponse->isFailure())->toBeTrue();
            });

            test('Should fail if non-numeric value is provided', function () {
                $candidate = 'abc';
                $attribute = new Attribute('nItem', $candidate, 'parentTag');
                $numeroItem = new NumeroItem('parentTag');
                $sut = new ReflectionMethod($numeroItem, 'validateAttributeValue');
                $sutResponse = $sut->invoke($numeroItem, $attribute);
                expect($sutResponse->isFailure())->toBeTrue();
            });
        });
    });
});
