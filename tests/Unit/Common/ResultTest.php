<?php
use BradiNfeApi\Common\Result;

describe('Result', function () {
    describe('.makeSuccess()', function () {
        test('Should be return a Result with a value on success', function () {
            $sut = Result::makeSuccess('validValue');
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBe('validValue');
        });
    });
 });
