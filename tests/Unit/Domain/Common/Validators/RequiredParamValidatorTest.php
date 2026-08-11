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
        });
    });
});
