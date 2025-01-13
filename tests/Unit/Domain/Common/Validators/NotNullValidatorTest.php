<?php

use BradiNfeApi\Domain\Common\Validators\NotNullValidator;

describe('NotNullValidator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid string is provided', function () {
            $sut = new NotNullValidator('testField');
            $sutResponse = $sut->validate('aValidValue');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });
    });
});
