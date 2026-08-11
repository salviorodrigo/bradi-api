<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoEmissaoNotaFiscalValidator;

describe('IsTipoEmissaoNotaFiscalValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsTipoEmissaoNotaFiscalValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsTipoEmissaoNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'normal' => '1',
                'contingencia_fs_ia' => '2',
                'contingencia_epec' => '3',
                'contingencia_scan' => '4',
                'contingencia_fs_da' => '5',
                'contingencia_svc_an' => '6',
                'contingencia_svc_rs' => '7',
                'contingencia_nfce' => '9',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsTipoEmissaoNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
            })->with([
                'out_of_range' => '8',
                'zero' => '0',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
