<?php

use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNullError;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;

describe('NotNullValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate('aValidValue');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a fail Result if a empty string is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate('');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNullError::class);
        });

        test('Should be return a success Result if a positive number is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate(99);
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a success Result if a negative number is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate(-99);
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a fail Result if a zero is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate(0);
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNullError::class);

            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate('0');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNullError::class);
        });

        test('Should be return a succeed Result if an object is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate(new stdClass);
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a fail Result if a null is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate(null);
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNullError::class);
        });

        test('Should be return a fail Result if an empty array is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate([]);
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNullError::class);
        });
    });
});
