<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\MinStringLengthValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('MinStringLengthValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\MinStringLengthValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should expose the configured min length', function () {
                $sut = new MinStringLengthValidator(4);
                expect($sut->minStringLength)->toBe(4);
            });
        });

        describe('check()', function () {
            test('Should succeed if the string length is at least the min', function (string $candidate) {
                $sut = new MinStringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'exact_length' => 'abcd',
                'longer' => 'abcde',
            ]);

            test('Should fail if the string is shorter than the min', function (string $candidate) {
                $sut = new MinStringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain at least 4 characters.');
            })->with([
                'shorter' => 'abc',
                'empty' => '',
            ]);

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new MinStringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain at least 4 characters.');
            })->with([
                'integer' => 10000,
                'array' => [['abcd']],
                'null' => null,
            ]);
        });
    });
});
