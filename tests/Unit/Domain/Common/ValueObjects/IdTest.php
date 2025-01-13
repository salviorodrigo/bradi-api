<?php

use BradiNfeApi\Common\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Id;

describe('Id', function () {
    describe('.parse()', function () {
        test('Should be return a success Result with Id if a valid value is provided', function () {
            $sut = Id::parse('aValidValue');
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->hasValue())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Id::class);
            expect($sut->getData()->value)->toBe('aValidValue');
        });

        test('Should be return a failure Result if a number is provided', function () {
            $sut = Id::parse(99);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should be return a failure Result if an object is provided', function () {
            $sut = Id::parse(new \stdClass);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should be return a failure Result if an array is provided', function () {
            $sut = Id::parse([]);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should be return a failure Result if null is provided', function () {
            $sut = Id::parse(null);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });

        test('Should be return a failure Result if an empty string is provided', function () {
            $sut = Id::parse('');
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });
    });
});
