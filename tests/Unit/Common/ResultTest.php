<?php

use BradiNfeApi\Common\Exceptions\GenericApiError;
use BradiNfeApi\Common\Result;

describe('Result', function () {
    describe('.makeSuccess()', function () {
        test('Should be return a Result with a value on success', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBe('validValue');
        });

        test('Should be return a Result without value when nothing is provided', function () {
            $sut = Result::makeSuccess();
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBe(null);
        });

        test('Should throw an error if user try get an error when Result is a success', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->isSuccess())->toBeTruthy();
            $sut->getError();
        })->throws(Exception::class, 'Result is not an error.');

        test('Should throw an error if user try make a success with ApiError', function () {
            Result::makeSuccess(new GenericApiError);
        })->throws(Exception::class, 'This method doesn\'t accept Error\'s.');

        test('Should throw an error if user try make a success with a generic Error', function () {
            Result::makeSuccess(new Error('A Generic Error.'));
        })->throws(Exception::class, 'This method doesn\'t accept Error\'s.');

        test('Should throw an error if user try make a success with a generic Exception', function () {
            Result::makeSuccess(new Exception('A Generic Exception.'));
        })->throws(Exception::class, 'This method doesn\'t accept Error\'s.');
    });

    describe('.makeFailure()', function () {
        test('Should be return an Exception on failure', function () {
            $sut = Result::makeFailure(new GenericApiError);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(Exception::class);
        });

        test('Should throw an error if user try get an valid value when Result is a failure', function () {
            $sut = Result::makeFailure(new GenericApiError);
            expect($sut->isSuccess())->toBeFalsy();
            $sut->getData();
        })->throws(Exception::class, 'Result is an error.');
    });

    describe('.hasValue()', function () {
        test('Should be truthy if Result.getData() has a non empty value', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->hasValue())->toBeTruthy();
        });

        test('Should be falsy if Result.getData() is an empty string', function () {
            $sut = Result::makeSuccess('');
            expect($sut->hasValue())->toBeFalsy();
        });

        test('Should be falsy if Result.getData() is null', function () {
            $sut = Result::makeSuccess(null);
            expect($sut->hasValue())->toBeFalsy();
        });

        test('Should be falsy if Result.getData() is false', function () {
            $sut = Result::makeSuccess(false);
            expect($sut->hasValue())->toBeFalsy();
        });

        test('Should be falsy if Result.getData() is zero', function () {
            $sut = Result::makeSuccess(0);
            expect($sut->hasValue())->toBeFalsy();

            $sut = Result::makeSuccess('0');
            expect($sut->hasValue())->toBeFalsy();
        });

        test('Should throw an error if Result is a failure', function () {
            $sut = Result::makeFailure(new GenericApiError);
            expect($sut->isSuccess())->toBeFalsy();
            $sut->hasValue();
        })->throws(Exception::class, 'Result is an error.');
    });
});
