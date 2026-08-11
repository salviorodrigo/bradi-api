<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsCodigoNotaFiscalValidator;

describe('IsCodigoNotaFiscalValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsCodigoNotaFiscalValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid code is provided', function (string $candidate) {
                $sut = new IsCodigoNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '48562315',
                'non_sequential_ascending' => '19283746',
            ]);

            test('Should fail if the code length is not 8', function (string $candidate) {
                $sut = new IsCodigoNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must contain exactly 8 characters.');
            })->with([
                'too_short' => '4856231',
                'too_long' => '485623158',
            ]);

            test('Should fail if the code is a sequential numeric series', function () {
                $sut = new IsCodigoNotaFiscalValidator;
                $sutResponse = $sut->check('12345678');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be a sequential numeric series.');
            });

            test('Should fail if the code contains all repeated digits', function () {
                $sut = new IsCodigoNotaFiscalValidator;
                $sutResponse = $sut->check('44444444');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain all repeated digits.');
            });

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsCodigoNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be numeric.');
            })->with([
                'alphanumeric' => '4856231A',
                'masked' => '4.856.231',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
