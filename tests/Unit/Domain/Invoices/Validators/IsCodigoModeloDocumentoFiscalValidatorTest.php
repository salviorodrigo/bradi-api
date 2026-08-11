<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\IsCodigoModeloDocumentoFiscalValidator;

describe('IsCodigoModeloDocumentoFiscalValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\IsCodigoModeloDocumentoFiscalValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsCodigoModeloDocumentoFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'nfe' => '55',
                'nfce' => '65',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsCodigoModeloDocumentoFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be a valid mod according MOC NFe e NFCe (7.0) - Anexo I..');
            })->with([
                'unknown_model' => '57',
                'single_digit' => '5',
                'alphanumeric' => '5A',
                'empty' => '',
            ]);
        });
    });
});
