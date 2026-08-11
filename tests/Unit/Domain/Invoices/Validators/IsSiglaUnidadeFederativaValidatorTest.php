<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\IsSiglaUnidadeFederativaValidator;

describe('IsSiglaUnidadeFederativaValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\IsSiglaUnidadeFederativaValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsSiglaUnidadeFederativaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'sao_paulo' => 'SP',
                'rio_de_janeiro' => 'RJ',
                'exterior' => 'EX',
            ]);

            test('Should fail in invalid options', function (mixed $candidate) {
                $sut = new IsSiglaUnidadeFederativaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be a valid UF according MOC NFe e NFCe (7.0) - Anexo I..');
            })->with([
                'unknown_acronym' => 'XX',
                'lowercase' => 'sp',
                'uf_code' => '35',
                'empty' => '',
                'null' => null,
            ]);
        });
    });
});
