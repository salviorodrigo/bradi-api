<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\MaxValueValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('MaxValueValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\MaxValueValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should expose the configured max value', function () {
                $sut = new MaxValueValidator(10);
                expect($sut->maxValue)->toBe(10.0);
            });
        });

        describe('check()', function () {
            test('Should succeed if the value is up to the max', function (mixed $candidate) {
                $sut = new MaxValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'lower' => '9.99',
                'exact_value' => '10',
                'negative' => '-10',
                'with_leading_zeros' => '09',
            ]);

            test('Should fail if the value is greater than the max', function (mixed $candidate) {
                $sut = new MaxValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be greater than 10.');
            })->with([
                'greater' => '10.01',
                'integer' => 11,
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new MaxValueValidator(10);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be greater than 10.');
            })->with([
                'alphanumeric' => '1A',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
