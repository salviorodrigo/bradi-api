<?php

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotXmlTagError;
use BradiNfeApi\Domain\Common\Validators\IsXmlTagValidator;

describe('IsStringValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid xml string is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate('<validTag>aValue</validTag>');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be fail if a non xml string is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate('LoseIp<validTag>aValue</validTag>Sum');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNotXmlTagError::class);
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate(new stdClass);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->isSuccess())->toBeFalsy();
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate(11);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->isSuccess())->toBeFalsy();
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate(['<ide><cUF>11</cUF></ide>']);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->isSuccess())->toBeFalsy();
        });

        test('Should be return a failure Result if null given', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate(null);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->isSuccess())->toBeFalsy();
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate(true);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->isSuccess())->toBeFalsy();
        });
    });
});
