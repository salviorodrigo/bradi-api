<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsCodigoMercosulValidator;

describe('IsCodigoMercosulValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsCodigoMercosulValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if an 8-digit numeric value is provided', function (string $candidate) {
                $sut = new IsCodigoMercosulValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'standard' => '01012100',
                'without_leading_zeros' => '85171231',
            ]);

            test('Should succeed if the exception code is provided', function () {
                $sut = new IsCodigoMercosulValidator;
                $sutResponse = $sut->check('00');
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if another value is provided', function (mixed $candidate) {
                $sut = new IsCodigoMercosulValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be "00" or an 8-digit numeric value.');
            })->with([
                'too_short' => '0101210',
                'too_long' => '010121000',
                'alphanumeric' => '0101210A',
                'masked' => '0101.21.00',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
