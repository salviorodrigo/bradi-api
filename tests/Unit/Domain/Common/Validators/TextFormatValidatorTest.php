<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\TextFormatValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('TextFormatValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\TextFormatValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the text has no surrounding or consecutive spaces', function (string $candidate) {
                $sut = new TextFormatValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'single_word' => 'aValue',
                'multiple_words' => 'a value with spaces',
                'empty' => '',
            ]);

            test('Should fail if the text starts with spaces', function () {
                $sut = new TextFormatValidator;
                $sutResponse = $sut->check(' aValue');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot start with spaces.');
            });

            test('Should fail if the text ends with spaces', function () {
                $sut = new TextFormatValidator;
                $sutResponse = $sut->check('aValue ');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot end with spaces.');
            });

            test('Should fail if the text contains consecutive spaces', function () {
                $sut = new TextFormatValidator;
                $sutResponse = $sut->check('a  value');
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('cannot contain consecutive spaces.');
            });

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new TextFormatValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a string.');
            })->with([
                'integer' => 1058,
                'array' => [['aValue']],
                'null' => null,
            ]);
        });
    });
});
