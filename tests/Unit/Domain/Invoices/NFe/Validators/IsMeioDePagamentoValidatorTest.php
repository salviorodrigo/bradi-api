<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsMeioDePagamentoValidator;

describe('IsMeioDePagamentoValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsMeioDePagamentoValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsMeioDePagamentoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'dinheiro' => '01',
                'cartao_de_credito' => '03',
                'boleto_bancario' => '15',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsMeioDePagamentoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be provided according field tPag of MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'unknown_code' => '07',
                'without_leading_zero' => '1',
                'alphanumeric' => '0A',
                'empty' => '',
            ]);
        });
    });
});
