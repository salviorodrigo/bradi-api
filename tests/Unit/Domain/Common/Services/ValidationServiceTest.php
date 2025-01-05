<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Services\ValidationService;

describe('ValidationService', function () {
    describe('.construct()', function () {
        test('Should throw if validators is not provided', function () {
            new ValidationService([]);
        })->throws(InvalidArgumentException::class, 'Validators must be provided.');

        test('Should throw if an array with one ou more value that does not implement Validator interface is provided', function () {
            new ValidationService([new \stdClass]);
        })->throws(InvalidArgumentException::class, 'Concrete validators must implement IValidator interface.');
    });
});
