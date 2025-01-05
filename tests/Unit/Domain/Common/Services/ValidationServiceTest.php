<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Tests\Doubles\Domain\Common\Validators\FakeValidator;

describe('ValidationService', function () {
    describe('.construct()', function () {
        test('Should be create a ValidationService on success', function () {
            $sut = new ValidationService([new FakeValidator('fieldName')]);
            expect($sut)->toBeInstanceOf(ValidationService::class);
        });

        test('Should throw if validators is not provided', function () {
            new ValidationService([]);
        })->throws(InvalidArgumentException::class, 'Validators must be provided.');

        test('Should throw if an array with one ou more value that does not implement Validator interface is provided', function () {
            new ValidationService([new \stdClass]);
        })->throws(InvalidArgumentException::class, 'Concrete validators must implement IValidator interface.');
    });

    describe('.verify()', function () {
        test('Should return a success if validators succeed', function () {
            $sut = new ValidationService([new FakeValidator('fieldName')]);
            $sutResponse = $sut->verify('aValidValue');
            expect($sutResponse->isSuccess())->toBeTruthy();
        });
    });
});
