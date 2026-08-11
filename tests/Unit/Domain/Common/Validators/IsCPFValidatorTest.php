<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsCPFValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsCPFValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsCPFValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid CPF is provided', function (string $candidate) {
                $sut = new IsCPFValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with(datasets('cpfs.valid'));

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsCPFValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a brazilian CPF.');
            })->with([
                'masked' => '529.982.247-25',
                'alphanumeric' => '5299822472A',
                'empty' => '',
                'null' => null,
            ]);

            test('Should fail if the digits amount is not 11', function (string $candidate) {
                $sut = new IsCPFValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain 11 digits.');
            })->with(datasets('cpfs.invalid.wrong_size'));

            test('Should fail if all digits are repeated', function (string $candidate) {
                $sut = new IsCPFValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain 11 digits.');
            })->with(datasets('cpfs.invalid.repeated_digits'));

            test('Should fail if check digits are incorrect', function (string $candidate) {
                $sut = new IsCPFValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('invalid check digits.');
            })->with([
                'incorrect_checksum' => '45678912355',
                'wrong_last_digit' => '52998224724',
            ]);
        });
    });
});
