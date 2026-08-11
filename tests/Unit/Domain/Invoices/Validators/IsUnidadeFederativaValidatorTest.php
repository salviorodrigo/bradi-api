<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\IsUnidadeFederativaValidator;

describe('IsUnidadeFederativaValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\IsUnidadeFederativaValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsUnidadeFederativaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'first_code' => '11',
                'sao_paulo' => '35',
                'exterior' => '99',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsUnidadeFederativaValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('must be cUF according MOC NFe e NFCe (7.0) - Anexo I.');
            })->with([
                'unknown_code' => '10',
                'uf_acronym' => 'SP',
                'single_digit' => '3',
                'empty' => '',
            ]);
        });
    });
});
