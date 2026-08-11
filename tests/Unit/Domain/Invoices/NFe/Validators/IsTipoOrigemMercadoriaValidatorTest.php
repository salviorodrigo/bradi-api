<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsTipoOrigemMercadoriaValidator;

describe('IsTipoOrigemMercadoriaValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsTipoOrigemMercadoriaValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsTipoOrigemMercadoriaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'nacional' => '0',
                'estrangeira_importacao_direta' => '1',
                'estrangeira_mercado_interno' => '2',
                'nacional_conteudo_importacao_superior_40' => '3',
                'nacional_processos_produtivos_basicos' => '4',
                'nacional_conteudo_importacao_inferior_40' => '5',
                'estrangeira_importacao_direta_sem_similar' => '6',
                'estrangeira_mercado_interno_sem_similar' => '7',
                'nacional_conteudo_importacao_superior_70' => '8',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsTipoOrigemMercadoriaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be one of 0, 1, 2, 3, 4, 5, 6, 7 or 8 according orig of MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'out_of_range' => '9',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
