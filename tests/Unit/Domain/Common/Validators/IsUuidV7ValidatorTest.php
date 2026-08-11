<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsUuidV7Validator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsUuidV7Validator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsUuidV7Validator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid uuid version 7 is provided', function (string $candidate) {
                $sut = new IsUuidV7Validator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
                expect($sutResponse->hasValue())->toBeFalse();
            })->with([
                'lowercase' => '01947ac8-cc4d-7ebc-af74-85ab74ae80da',
                'uppercase' => '01947AC8-CC4D-7EBC-AF74-85AB74AE80DA',
            ]);

            test('Should fail if another uuid version is provided', function (string $candidate) {
                $sut = new IsUuidV7Validator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a valid UUID v7.');
            })->with([
                'version_4' => '9b2e4f52-3f3a-4c1e-9f2a-1b0c9d8e7f60',
                'nil' => '00000000-0000-0000-0000-000000000000',
            ]);

            test('Should fail if a malformed value is provided', function (mixed $candidate) {
                $sut = new IsUuidV7Validator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a valid UUID v7.');
            })->with([
                'incomplete' => '01947ac8-cc4d-7ebc-af74',
                'invalid_hex_char' => '01947ac8-cc4d-7ebc-af74-85ab74ae80dz',
                'text' => 'aValue',
                'empty' => '',
            ]);
        });
    });
});
