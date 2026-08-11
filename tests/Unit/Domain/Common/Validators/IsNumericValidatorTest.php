<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsNumericValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsNumericValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsNumericValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('__construct()', function () {
            test('Should disallow leading zeros by default', function () {
                $sut = new IsNumericValidator;
                expect($sut->allowLeadingZeros)->toBeFalse();
                expect($sut->decimalSeparator)->toBe('.');
                expect($sut->thousandsSeparator)->toBe(',');
            });
        });

        describe('check()', function () {
            test('Should succeed if a numeric value is provided', function (mixed $candidate) {
                $sut = new IsNumericValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'integer_string' => '1058',
                'decimal_string' => '10.58',
                'zero' => '0',
                'zero_with_decimals' => '0.58',
                'negative' => '-1058',
                'integer' => 1058,
                'float' => 10.58,
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsNumericValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be numeric.');
            })->with([
                'alphanumeric' => '10A8',
                'masked' => '1.058,00',
                'empty' => '',
                'null' => null,
                'boolean' => true,
            ]);

            test('Should fail if leading zeros are provided and they are not allowed', function (string $candidate) {
                $sut = new IsNumericValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain leading zeros.');
            })->with([
                'single' => '01058',
                'multiple' => '0001058',
            ]);

            test('Should succeed if leading zeros are provided and they are allowed', function (string $candidate) {
                $sut = new IsNumericValidator(allowLeadingZeros: true);
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'single' => '01058',
                'multiple' => '0001058',
            ]);

            test('Should fail if the value is surrounded by spaces', function (string $candidate) {
                $sut = new IsNumericValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'leading space' => ' 1058',
                'trailing space' => "1058\n",
            ]);

            test('Should fail if forbidden characters are provided', function () {
                $sut = new IsNumericValidator;
                $sutResponse = $sut->check('1e5');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('The numeric value contains forbidden characters: e.');
            });
        });
    });
});
