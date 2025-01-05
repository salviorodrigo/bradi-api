<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\Exceptions\IsNotStringError;
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

        test('Should return a failure with a ValidationError if at least one validator fail', function () {
            $fakeValidator = Mockery::mock(FakeValidator::class);
            $fakeValidator->shouldReceive('validate')->andReturn(
                Result::makeSuccess(),
                Result::makeFailure(new IsNotStringError('fieldOne')));
            $sut = new ValidationService([$fakeValidator, $fakeValidator]);
            $sutResponse = $sut->verify('aValidValue');
            expect($sutResponse->isSuccess())->toBeFalsy();
            expect($sutResponse->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
