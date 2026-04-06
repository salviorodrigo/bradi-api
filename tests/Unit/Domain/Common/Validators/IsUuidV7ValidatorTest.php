<?php

use BradiNfeApi\Domain\Common\Validators\IsUuidV7Validator;

describe('IsUuidV7Validator', function () {
    describe('.validate()', function () {
        test('Should be return a success Result if a valid uuid version 7 is provided', function () {
            $sut = new IsUuidV7Validator('testField', __METHOD__);
            $sutResponse = $sut->check('01947ac8-cc4d-7ebc-af74-85ab74ae80da');
            expect($sutResponse->isSuccess())->toBeTruthy();
            expect($sutResponse->hasValue())->toBeFalsy();
        });
    });
});
