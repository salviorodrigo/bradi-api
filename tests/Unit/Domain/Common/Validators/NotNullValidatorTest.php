<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\NotNullValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('NotNullValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\NotNullValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a filled value is provided', function (mixed $candidate) {
                $sut = new NotNullValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'string' => 'aValue',
                'zero_as_string' => '0',
                'filled_array' => [['aValue']],
                'filled_object' => [(object) ['name' => 'aValue']],
            ]);

            // Regressao: o despacho por gettype() nao tinha metodo para escalar,
            // entao check() lancava Error em vez de devolver Result.
            test('Should succeed if a scalar value is provided', function (mixed $candidate) {
                $sut = new NotNullValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'integer' => 5,
                'zero_as_integer' => 0,
                'float' => 1.5,
                'zero_as_float' => 0.0,
                'true' => true,
                'false' => false,
            ]);

            test('Should fail if null is provided', function () {
                $sut = new NotNullValidator;
                $sutResponse = $sut->check(null);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be null.');
            });

            test('Should fail if an empty value is provided', function (mixed $candidate) {
                $sut = new NotNullValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot be null.');
            })->with([
                'empty_string' => '',
                'spaces_only' => '   ',
                'null_as_string' => 'null',
                'empty_array' => [[]],
                'empty_object' => [(object) []],
            ]);
        });
    });
});
