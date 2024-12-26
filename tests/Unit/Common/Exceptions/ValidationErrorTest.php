<?php

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Tests\Doubles\Domain\Common\Validators\Exceptions\FakeValidatorError;

describe('ValidationError', function () {
    test('Should be return a ValidationError with status 400 and all provided ValidatorError messages', function () {
        $sut = new ValidationError([new FakeValidatorError('fieldOne', 'A error message')]);
        expect($sut->httpStatus)->toBe('400');
        expect($sut->details['message'])->toBeArray();
        expect($sut->details['message']['fieldOne'])->toBe(['A error message']);

        $sut = new ValidationError([
            new FakeValidatorError('fieldOne', 'A error message'),
            new FakeValidatorError('fieldTwo', 'A error message'),
            new FakeValidatorError('fieldThree', 'A error message'),
            new FakeValidatorError('fieldThree', 'A second error message'),
        ]);
        expect($sut->httpStatus)->toBe('400');
        expect($sut->details['message'])->toBeArray();
        expect($sut->details['message']['fieldOne'])->toBe(['A error message']);
        expect($sut->details['message']['fieldTwo'])->toBe(['A error message']);
        expect($sut->details['message']['fieldThree'])->toBe(['A error message', 'A second error message']);
    });

    test('Should be return a ValidationError without duplicated ValidatorError messages', function () {
        $sut = new ValidationError([
            new FakeValidatorError('fieldOne', 'A error message'),
            new FakeValidatorError('fieldOne', 'A error message'),
        ]);
        expect($sut->httpStatus)->toBe('400');
        expect($sut->details['message'])->toBeArray();
        expect($sut->details['message']['fieldOne'])->toBe(['A error message']);
    });
});
