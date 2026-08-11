<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsIndicadorTipoDestinatarioValidator;

describe('IsIndicadorTipoDestinatarioValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsIndicadorTipoDestinatarioValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsIndicadorTipoDestinatarioValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'contribuinte_icms' => '1',
                'isento' => '2',
                'nao_contribuinte_icms' => '9',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsIndicadorTipoDestinatarioValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be 1, 2 or 9 according field indIEDest of MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'out_of_range' => '3',
                'zero' => '0',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
