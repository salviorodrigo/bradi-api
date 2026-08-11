<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\MaxStringLengthValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('MaxStringLengthValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\MaxStringLengthValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should expose the configured max length', function () {
                $sut = new MaxStringLengthValidator(4);
                expect($sut->maxStringLength)->toBe(4);
            });
        });

        describe('check()', function () {
            test('Should succeed if the string length is up to the max', function (string $candidate) {
                $sut = new MaxStringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'shorter' => 'abc',
                'exact_length' => 'abcd',
                'empty' => '',
            ]);

            test('Should fail if the string is longer than the max', function () {
                $sut = new MaxStringLengthValidator(4);
                $sutResponse = $sut->check('abcde');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain more than 4 characters.');
            });

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new MaxStringLengthValidator(4);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain more than 4 characters.');
            })->with([
                'integer' => 10,
                'array' => [['abc']],
                'null' => null,
            ]);
        });
    });
});
