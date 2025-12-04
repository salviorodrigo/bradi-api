<?php

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
    });

    describe('.validate()', function () {
        test('Should be fail if a non xml string is provided', function () {
            $sut = new IsXmlTagValidator('testField');
            $sutResponse = $sut->validate('LoseIp<validTag>aValue</validTag>Sum');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(IsNotXmlTagError::class);
        });
    });
});
