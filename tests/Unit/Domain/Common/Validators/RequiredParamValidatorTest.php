<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\RequiredParamValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('RequiredParamValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\RequiredParamValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a filled value is provided', function (mixed $candidate) {
                $sut = new RequiredParamValidator;
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
                $sut = new RequiredParamValidator;
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

            test('Should fail if an empty value is provided', function (mixed $candidate) {
                $sut = new RequiredParamValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('required param.');
            })->with([
                'empty_string' => '',
                'spaces_only' => '   ',
                'null_as_string' => 'null',
                'empty_array' => [[]],
                'empty_object' => [(object) []],
            ]);

            // Regressao: o caso de uso principal do validador lancava
            // Error: Call to undefined method ...::isEmptyNULL().
            test('Should fail if null is provided', function () {
                $sut = new RequiredParamValidator;
                $sutResponse = $sut->check(null);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('required param.');
            });
        });
    });
});
