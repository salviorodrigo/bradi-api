<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsCNPJValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsCNPJValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsCNPJValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid CNPJ is provided', function (string $candidate) {
                $sut = new IsCNPJValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '11222333000181',
                'with_leading_zeros' => '04840356000194',
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsCNPJValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a brazilian CNPJ.');
            })->with([
                'masked' => '12.345.678/0001-90',
                'alphanumeric' => '1122233300018A',
                'empty' => '',
                'null' => null,
            ]);

            test('Should fail if the digits amount is not 14', function (string $candidate) {
                $sut = new IsCNPJValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain 14 digits.');
            })->with([
                'too_short' => '1122233300018',
                'too_long' => '112223330001810',
            ]);

            test('Should fail if all digits are repeated', function (string $candidate) {
                $sut = new IsCNPJValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain 14 digits.');
            })->with(datasets('cnpjs.invalid.repeated_digits'));

            test('Should fail if check digits are incorrect', function (string $candidate) {
                $sut = new IsCNPJValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('invalid check digits.');
            })->with([
                'wrong_first_digit' => '11222333000171',
                'wrong_second_digit' => '11222333000182',
            ]);
        });
    });
});
