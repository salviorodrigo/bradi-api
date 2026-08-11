<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsModalidadeFreteValidator;

describe('IsModalidadeFreteValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsModalidadeFreteValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsModalidadeFreteValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'contratacao_remetente' => '0',
                'contratacao_destinatario' => '1',
                'contratacao_terceiros' => '2',
                'transporte_proprio_remetente' => '3',
                'transporte_proprio_destinatario' => '4',
                'sem_ocorrencia_transporte' => '9',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsModalidadeFreteValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be 0, 1, 2, 3, 4 or 9 according modFrete of MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'out_of_range' => '5',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
