<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsModalidadeBaseDeCalculoValidator;

describe('IsModalidadeBaseDeCalculoValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsModalidadeBaseDeCalculoValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsModalidadeBaseDeCalculoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'margem_valor_agregado' => '0',
                'pauta' => '1',
                'preco_tabelado_maximo' => '2',
                'valor_operacao' => '3',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsModalidadeBaseDeCalculoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be 0, 1, 2 or 3 according modBC of MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'out_of_range' => '4',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
