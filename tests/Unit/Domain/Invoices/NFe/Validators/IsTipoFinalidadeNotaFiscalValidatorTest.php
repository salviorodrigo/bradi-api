<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoFinalidadeNotaFiscalValidator;

describe('IsTipoFinalidadeNotaFiscalValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsTipoFinalidadeNotaFiscalValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsTipoFinalidadeNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'normal' => '0',
                'consumo_final' => '1',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsTipoFinalidadeNotaFiscalValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('it must be 1 to domestic or 0 case else.');
            })->with([
                'out_of_range' => '2',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
