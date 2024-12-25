<?php

use BradiNfeApi\Domain\Common\Validators\IsStringValidator;

describe('IsStringValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new IsStringValidator('testField');
            $sutResponse = $sut->validate('aValidValue');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });
    });
});
