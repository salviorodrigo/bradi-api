<?php

use BradiNfeApi\Domain\Invoices\Validators\Exceptions\NotFoundTagError;
use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

describe('IsStringValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new RequiredTagValidator('validTag');
            $sutResponse = $sut->validate('<validTag>aValue</validTag>');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be return a success Result if a valid string is provided, when xml string is a autoclose tag', function () {
            $sut = new RequiredTagValidator('validAutoCloseTag');
            $sutResponse = $sut->validate('<validAutoCloseTag/>');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });

        test('Should be fail if provided xml string doesn\'t contain a target xml tag', function () {
            $sut = new RequiredTagValidator('missingTag');
            $sutResponse = $sut->validate('<validTag>aValue</validTag>');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(NotFoundTagError::class);
        });
    });
});
