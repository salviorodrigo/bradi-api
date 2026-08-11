<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\IsValidCodigoBarrasValidator;

describe('IsValidCodigoBarrasValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\IsValidCodigoBarrasValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a numeric barcode is provided', function (string $candidate) {
                $sut = new IsValidCodigoBarrasValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'ean_13' => '7891234567895',
                'ean_8' => '78912345',
                'with_leading_zeros' => '07891234567895',
            ]);

            test('Should succeed if the product has no barcode', function () {
                $sut = new IsValidCodigoBarrasValidator;
                $sutResponse = $sut->check('SEM GTIN');
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if a non-numeric barcode is provided', function (mixed $candidate) {
                $sut = new IsValidCodigoBarrasValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('barcode must be numeric or "SEM GTIN".');
            })->with([
                'alphanumeric' => '789123456789A',
                'sem_gtin_lowercase' => 'sem gtin',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
