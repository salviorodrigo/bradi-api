<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\FormatDataHoraTZDValidator;

describe('FormatDataHoraTZDValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\FormatDataHoraTZDValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the value matches the YYYY-MM-DDTHH:mm:ss+00:00 format', function (string $candidate) {
                $sut = new FormatDataHoraTZDValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'negative_offset' => '2026-08-11T10:30:00-03:00',
                'positive_offset' => '2026-08-11T10:30:00+03:00',
                'first_day_of_year' => '2026-01-01T00:00:00-03:00',
                'last_day_of_year' => '2026-12-31T23:59:59-03:00',
            ]);

            test('Should fail if the value does not match the format', function (mixed $candidate) {
                $sut = new FormatDataHoraTZDValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())
                    ->toBe('The value must match the YYYY-MM-DDTHH:mm:ss+00:00 format.');
            })->with([
                'without_time_zone' => '2026-08-11T10:30:00',
                'with_zulu_time_zone' => '2026-08-11T10:30:00Z',
                'date_only' => '2026-08-11',
                'brazilian_format' => '11/08/2026 10:30:00',
                'invalid_month' => '2026-13-11T10:30:00-03:00',
                'invalid_day' => '2026-08-32T10:30:00-03:00',
                'invalid_hour' => '2026-08-11T24:30:00-03:00',
                'empty' => '',
                'integer' => 1058,
                'null' => null,
            ]);
        });
    });
});
