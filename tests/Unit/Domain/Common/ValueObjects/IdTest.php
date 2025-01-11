<?php

use BradiNfeApi\Domain\Common\ValueObjects\Id;

describe('Id', function () {
    describe('.parse()', function () {
        test('Should be return a success Result with Id if a valid value is provided', function () {
            $sut = Id::parse('aValidValue');
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->hasValue())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Id::class);
            expect($sut->getData()->value)->toBe('aValidValue');
        });
    });
});
