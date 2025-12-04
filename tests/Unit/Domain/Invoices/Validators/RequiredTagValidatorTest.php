<?php

use BradiNfeApi\Domain\Invoices\Validators\RequiredTagValidator;

describe('IsStringValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new RequiredTagValidator('validTag');
            $sutResponse = $sut->validate('<validTag>aValue</validTag>');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });
    });
});
