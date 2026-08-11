<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\StringLengthValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('StringLengthValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\StringLengthValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the string has the expected length', function () {
                $sut = new StringLengthValidator(4);
                $sutResponse = $sut->check('abcd');
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed if the string has one of the expected lengths', function (string $candidate) {
                $sut = new StringLengthValidator(2, 4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'first_length' => 'ab',
                'second_length' => 'abcd',
            ]);

            test('Should fail if the string has another length', function (string $candidate) {
                $sut = new StringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain exactly 4 characters.');
            })->with([
                'shorter' => 'abc',
                'longer' => 'abcde',
                'empty' => '',
            ]);

            test('Should list every expected length on the error message', function () {
                $sut = new StringLengthValidator(2, 4);
                $sutResponse = $sut->check('abc');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain one of the following lengths: 2, 4.');
            });

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new StringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain exactly 4 characters.');
            })->with([
                'integer' => 1058,
                'array' => [['abcd']],
                'null' => null,
            ]);
        });
    });
});
