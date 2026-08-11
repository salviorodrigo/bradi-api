<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\NFe\Validators\IsFinalidadeEmissaoValidator;

describe('IsFinalidadeEmissaoValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\NFe\Validators';
        $sut = $nameSpace . '\\IsFinalidadeEmissaoValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed in valid options', function (string $candidate) {
                $sut = new IsFinalidadeEmissaoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'normal' => '1',
                'complementar' => '2',
                'ajuste' => '3',
                'devolucao' => '4',
            ]);

            test('Should fail in invalid options', function (string $candidate) {
                $sut = new IsFinalidadeEmissaoValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('it must be 1 to normal, 2 to complement, 3 to adjust or 4 to return.');
            })->with([
                'out_of_range' => '5',
                'zero' => '0',
                'with_leading_zeros' => '01',
                'alphanumeric' => 'A',
                'empty' => '',
            ]);
        });
    });
});
