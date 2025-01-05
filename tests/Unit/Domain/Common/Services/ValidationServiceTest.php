<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Services\ValidationService;

describe('ValidationService', function () {
    describe('.construct()', function () {
        test('Should throw if validators is not provided', function () {
            new ValidationService([]);
        })->throws(InvalidArgumentException::class, 'Validators must be provided.');
    });
});
