<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\ValueObjects\FieldURI;

describe('FieldURI', function () {
    $sut = FieldURI::class;

    describe('__construct()', function () use ($sut) {
        test('Should succeed with :dataset', function (string $candidate) use ($sut) {
            $result = new $sut($candidate);

            expect($result->value)->toBe($candidate);
        })->with([
            'single_alpha_segment' => 'Invoice',
            'single_alphanumeric_segment' => 'Invoice01',
            'nested_alpha_segments' => 'invoice.tax.base',
            'nested_alphanumeric_segments' => 'invoice.tax.ICMS00.rate01',
        ]);

        test('Should throw with :dataset', function (string $candidate) use ($sut) {
            new $sut($candidate);
        })->with([
            'contains_hyphen' => 'Invoice-01',
            'starts_with_number' => '01Invoice',
            'contains_space' => 'invoice tax',
            'has_empty_segment' => 'invoice..tax',
        ])->throws(InvalidArgumentException::class);
    });
});
