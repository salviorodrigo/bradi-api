<?php

use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotStringError;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;

describe('IsStringValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new IsStringValidator('testField');
            $sutResponse = $sut->validate('aValidValue');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a failure Result with IsNotStringError if a number is provided', function () {
            $sut = new IsStringValidator('testField');
            $sutResponse = $sut->validate(99);
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNotStringError::class);
        });

        test('Should be return a failure Result with IsNotStringError if an object is provided', function () {
            $sut = new IsStringValidator('testField');
            $sutResponse = $sut->validate(new stdClass);
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNotStringError::class);
        });
    });
});
