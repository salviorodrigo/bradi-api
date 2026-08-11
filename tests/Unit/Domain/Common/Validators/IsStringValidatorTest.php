<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsStringValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsStringValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsStringValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a string is provided', function (string $candidate) {
                $sut = new IsStringValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'text' => 'aValue',
                'empty' => '',
                'numeric_string' => '1058',
                'spaces_only' => ' ',
            ]);

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new IsStringValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a string.');
            })->with([
                'integer' => 1058,
                'float' => 10.58,
                'boolean' => true,
                'array' => [['1058']],
                'null' => null,
            ]);
        });
    });
});
