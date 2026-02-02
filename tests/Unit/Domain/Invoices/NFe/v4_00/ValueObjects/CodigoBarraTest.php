<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoBarras;

/** Xml string example
 *
 * <cEAN>SEM GTIN</cEAN>
 */
describe('CodigoBarras', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string with a valid cEAN value is provided', function (string $fakeXmlValue, string $fakeXmlString) {
            $sut = CodigoBarras::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoBarras::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeXmlValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe($fakeXmlString);
        })->with([
            ['00020001', '<cEAN>00020001</cEAN>'],               // 8 chars
            ['SEM GTIN', '<cEAN>SEM GTIN</cEAN>'],               // literal with 8 chars
            ['123456789012', '<cEAN>123456789012</cEAN>'],       // 12 chars
            ['1234567890123', '<cEAN>1234567890123</cEAN>'],     // 13 chars
            ['12345678901234', '<cEAN>12345678901234</cEAN>'],   // 14 chars
        ]);

        test('Should be return a failure Result if non string is provided', function ($fakeXmlString) {
            $sut = CodigoBarras::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            new stdClass,                   // object
            11111111,                       // integer
            [['<cEAN>SEM GTIN</cEAN>']],    // array
            null,                           // null
            true,                           // boolean
            '',                             // empty string
        ]);

        test('Should be fail if a value with invalid length is provided', function ($fakeXmlString) {
            $sut = CodigoBarras::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with(
            [
                '<cEAN>1234567</cEAN>',         // 7 chars
                '<cEAN>123456789</cEAN>',       // 9 chars
                '<cEAN>12345678901</cEAN>',     // 11 chars
                '<cEAN>123456789012345</cEAN>', // 15 chars
            ]
        );
    });

    describe('::create()', function () {
        test('Should be succeed if a valid value is provided', function ($fakeTagValue) {
            $sut = CodigoBarras::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoBarras::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe($fakeTagValue);
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe("<cEAN>{$fakeTagValue}</cEAN>");
        })->with([
            '00020001',        // 8 chars
            'SEM GTIN',        // literal with 8 chars
            '123456789012',    // 12 chars
            '1234567890123',   // 13 chars
            '12345678901234',  // 14 chars
        ]);

        test('Should return a cEAN xml tag with the value SEM GTIN, if none is provided', function () {
            $sut = CodigoBarras::create('');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoBarras::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('SEM GTIN');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cEAN>SEM GTIN</cEAN>');
        });

        test('Should be fail if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoBarras::create(tagValue: $fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1234567',         // 7 chars
            '123456789',       // 9 chars
            '12345678901',     // 11 chars
            '123456789012345', // 15 chars
        ]);
    });

    describe('::validateTagValue()', function () {
        test('Should be true if a valid value is provided', function ($fakeTagValue) {
            $sut = CodigoBarras::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        })->with([
            '00020001',        // 8 chars
            'SEM GTIN',        // literal with 8 chars
            '123456789012',    // 12 chars
            '1234567890123',   // 13 chars
            '12345678901234',  // 14 chars
        ]);

        test('Should be false if a value with invalid length is provided', function ($fakeTagValue) {
            $sut = CodigoBarras::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        })->with([
            '1234567',         // 7 chars
            '123456789',       // 9 chars
            '12345678901',     // 11 chars
            '123456789012345', // 15 chars
        ]);
    });
});
