<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoSituacaoTributariaValidator;

describe('IsTipoSituacaoTributariaValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsTipoSituacaoTributariaValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsTipoSituacaoTributariaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'tributada_integralmente' => '00',
                'tributavel_aliquota_basica' => '01',
                'tributada_com_cobranca_st' => '10',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsTipoSituacaoTributariaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be a valid CST according MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'without_leading_zero' => '0',
                'unknown_code' => '11',
                'alphanumeric' => '0A',
                'empty' => '',
            ]);
        });
    });
});
