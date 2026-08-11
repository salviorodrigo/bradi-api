<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsIntegerValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsIntegerValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsIntegerValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if an integer value is provided', function (mixed $candidate) {
                $sut = new IsIntegerValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'integer_string' => '1058',
                'signed_positive' => '+1058',
                'signed_negative' => '-1058',
                'zero' => '0',
                'integer' => 1058,
            ]);

            test('Should fail if a decimal value is provided', function (mixed $candidate) {
                $sut = new IsIntegerValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be an integer.');
            })->with([
                'decimal_string' => '10.58',
                'float' => 10.58,
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsIntegerValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be numeric.');
            })->with([
                'alphanumeric' => '10A8',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
