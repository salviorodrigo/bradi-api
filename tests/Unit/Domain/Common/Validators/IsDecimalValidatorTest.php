<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsDecimalValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsDecimalValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsDecimalValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should not require a minimum of decimal digits by default', function () {
                $sut = new IsDecimalValidator(13, 2);
                expect($sut->maxIntegerDigits)->toBe(13);
                expect($sut->maxDecimalDigits)->toBe(2);
                expect($sut->minDecimalDigits)->toBe(0);
            });
        });

        describe('check()', function () {
            test('Should succeed if the value fits the declared precision', function (string $candidate) {
                $sut = new IsDecimalValidator(13, 2);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'with_decimals' => '1234.56',
                'without_decimals' => '1234',
                'negative' => '-1234.56',
                'max_integer_digits' => '1234567890123.56',
            ]);

            test('Should fail if the integer part is too long', function () {
                $sut = new IsDecimalValidator(2, 2);
                $sutResponse = $sut->check('123.45');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('integer part cannot contain more than 2 digits.');
            });

            test('Should fail if the decimal part is too long', function () {
                $sut = new IsDecimalValidator(13, 2);
                $sutResponse = $sut->check('1.234');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('decimal part cannot contain more than 2 digits.');
            });

            test('Should fail if the decimal part is shorter than the minimum', function (string $candidate) {
                $sut = new IsDecimalValidator(13, 2, 2);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('decimal part must contain at least 2 digits.');
            })->with([
                'single_decimal_digit' => '1.5',
                'without_decimals' => '1',
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsDecimalValidator(13, 2);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be numeric.');
            })->with([
                'alphanumeric' => '12A.56',
                'masked' => '1.234,56',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
