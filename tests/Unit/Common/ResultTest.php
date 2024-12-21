<?php

use BradiNfeApi\Common\ApiError;
use BradiNfeApi\Common\Exceptions\GenericApiError;
use BradiNfeApi\Common\Result;

describe('Result', function () {
    describe('.makeSuccess()', function () {
        test('Should be return a Result with a value on success', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBe('validValue');
        });

        test('Should throw an error if user try get an error when Result is a success', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->isSuccess())->toBeTruthy();
            $sut->getError();
        })->throws(Exception::class, 'Result is not an error.');

        test('Should be return a Result without value when nothing is provided', function () {
            $sut = Result::makeSuccess();
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBe(null);
        });
    });

    describe('.makeFailure()', function () {
        test('Should be return an ApiError on failure', function () {
            $sut = Result::makeFailure(new GenericApiError);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ApiError::class);
        });
    });
});
