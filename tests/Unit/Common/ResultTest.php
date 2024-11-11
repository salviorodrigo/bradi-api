<?php
use BradiNfeApi\Common\Result;

describe('Result', function () {
    describe('.makeSuccess()', function () {
        test('Should be return a Result with a value on success', function () {
            $successResult = Result::makeSuccess('validValue');
            expect($successResult->isSuccess())->toBeTruthy();
            expect($successResult->getData())->toBe('validValue');
        });
    });
 });
