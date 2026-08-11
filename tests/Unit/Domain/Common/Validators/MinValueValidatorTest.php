<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\MinValueValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('MinValueValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\MinValueValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should expose the configured min value', function () {
                $sut = new MinValueValidator(10);
                expect($sut->minValue)->toBe(10.0);
            });
        });

        describe('check()', function () {
            test('Should succeed if the value is at least the min', function (mixed $candidate) {
                $sut = new MinValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'exact_value' => '10',
                'greater' => '10.01',
                'integer' => 11,
            ]);

            test('Should fail if the value is less than the min', function (mixed $candidate) {
                $sut = new MinValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be less than 10.');
            })->with([
                'lower' => '9.99',
                'negative' => '-10',
                'with_leading_zeros' => '09',
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new MinValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be less than 10.');
            })->with([
                'alphanumeric' => '1A',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
