<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\IsCodigoMunicipioValidator;

describe('IsCodigoMunicipioValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\IsCodigoMunicipioValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid city code is provided', function (string $candidate) {
                $sut = new IsCodigoMunicipioValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'sao_paulo' => '3550308',
                'rio_de_janeiro' => '3304557',
                'exterior' => '9999999',
            ]);

            test('Should fail if the check digit is incorrect', function (string $candidate) {
                $sut = new IsCodigoMunicipioValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('city code is invalid.');
            })->with([
                'sao_paulo_with_wrong_digit' => '3550300',
                'unknown_code' => '1234567',
            ]);

            test('Should fail if a non-numeric value is provided', function (mixed $candidate) {
                $sut = new IsCodigoMunicipioValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('city code is invalid.');
            })->with([
                'alphanumeric' => '355030A',
                'masked' => '3.550.308',
                'empty' => '',
                'null' => null,
            ]);

            test('Should fail if the prefix is not a valid federative unit code', function () {
                $sut = new IsCodigoMunicipioValidator;
                $sutResponse = $sut->check('1050301');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('city code prefix must be a valid cUF according MOC NFe e NFCe (7.0) - Anexo I.');
            });
        });
    });
});
